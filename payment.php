<?php require_once('header.php'); ?>

<?php
// Check if the agent is logged in or not
if(!isset($_SESSION['agent'])) {
	header('location: '.BASE_URL.'logout.php');
	exit;
} else {
	// If agent is logged in, but admin make him inactive, then force logout this user.
	$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=? AND agent_access=?");
	$statement->execute(array($_SESSION['agent']['agent_id'],0));
	$total = $statement->rowCount();
	if($total) {
		header('location: '.BASE_URL.'logout.php');
		exit;
	}
}
?>

<div class="dashboard-area bg-area">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-12">
				<div class="option-board">
					<?php require_once('dashboard-menu.php'); ?>
				</div>
			</div>
			<div class="col-md-9 col-sm-12">
				<div class="detail-dashboard">

					<h1>Make Payment</h1>
					<?php
					if($error_message != '') {
						echo "<script>alert('".$error_message."')</script>";
					}
					if($success_message != '') {
						echo "<script>alert('".$success_message."')</script>";
					}
					?>
					<div style="margin-bottom: 20px;">* = Required Fields</div>
					<div class="add-car-area">
						<div class="row">
							<div class="information-form">
								
								<?php
								if(isset($_REQUEST['msg'])) {
									echo '<div class="error" style="padding-left: 15px;padding-bottom:15px;">'.$_REQUEST['msg'].'</div>';
								}
								?>

								<form class="paypal" action="<?php echo BASE_URL; ?>payment/paypal/payment_process.php" method="post" id="paypal_form" target="_blank">
									
									<input type="hidden" name="cmd" value="_xclick" />
									<input type="hidden" name="no_note" value="1" />
									<input type="hidden" name="lc" value="UK" />
									<input type="hidden" name="currency_code" value="USD" />
									<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />

									<input type="hidden" name="agent_id" value="<?php echo $_SESSION['agent']['agent_id']; ?>">

									<div class="form-row">
										<div class="clear"></div>
										<div class="form-group col-md-6 col-sm-6 option-item">
											<label for="">Select a Plan *</label>
											<select data-placeholder="Choose a plan" class="form-control chosen-select" name="pricing_plan_id">
												<option></option>
												<?php
												$statement = $pdo->prepare("SELECT * FROM tbl_pricing_plan ORDER BY pricing_plan_name ASC");
												$statement->execute();
												$result = $statement->fetchAll(PDO::FETCH_ASSOC);
												foreach ($result as $row) {
													?>			
													<option value="<?php echo $row['pricing_plan_id']; ?>"><?php echo $row['pricing_plan_name'].' ($'.$row['pricing_plan_price'].')'; ?></option>
													<?php
												}
												?>
											</select>
										</div>
										<div class="clear"></div>					
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Select Payment Date *</label>
											<input autocomplete="off" type="text" class="form-control datepicker" name="payment_date" placeholder="Payment Date" value="<?php echo date('Y-m-d'); ?>">
										</div>
									</div>
									<div class="form-group col-md-12">
										<input type="submit" class="btn btn-primary" value="Pay Now" name="form1">
									</div>

								</form>

							</div>
						</div>
					</div>


					<h1>Payment History</h1>
					<?php
					$statement = $pdo->prepare("
											SELECT

											t1.payment_date,
											t1.expire_date,
											t1.txnid,
											t1.paid_amount,
											t1.pricing_plan_id,
											t2.pricing_plan_id,
											t2.pricing_plan_name

											FROM tbl_payment t1
											JOIN tbl_pricing_plan t2
											ON t1.pricing_plan_id = t2.pricing_plan_id
											WHERE t1.agent_id=? AND t1.payment_status=?");
					$statement->execute(array($_SESSION['agent']['agent_id'],'Completed'));
					$total = $statement->rowCount();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					?>
					<?php if(!$total): ?>
					<div class="error">Result Not Found</div>
					<?php else: ?>
					<table id="example" class="display" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Serial</th>
								<th>Payment Date</th>
								<th>Expire Date</th>
								<th>Transaction Id</th>
								<th>Paid Amount</th>
								<th>Pricing Plan</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;				
							foreach ($result as $row) {
								$i++;
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['payment_date']; ?></td>
									<td><?php echo $row['expire_date']; ?></td>
									<td><?php echo $row['txnid']; ?></td>
									<td><?php echo $row['paid_amount']; ?></td>
									<td>
										<?php echo $row['pricing_plan_name']; ?>
									</td>
									<td>
										<?php
										$today = date('Y-m-d');
										if($today <= $row['expire_date'] && $today >=$row['payment_date'] ) {
											echo 'Active';
										} else {
											echo 'Expired';
										}
										?>
									</td>
								</tr>	
								<?php
							}
							?>
						</tbody>
					</table>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>