<?php require_once('header.php'); ?>


<section class="content-header">
	<div class="content-header-left">
		<h1>View Agent Payments</h1>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					
					<?php
					$statement = $pdo->prepare("
											SELECT
											t1.id,
											t1.agent_id,
											t1.payment_date,
											t1.expire_date,
											t1.txnid,
											t1.paid_amount,
											t1.pricing_plan_id,
											t1.payment_status,

											t2.pricing_plan_id,
											t2.pricing_plan_name,

											t3.agent_id,
											t3.agent_name,
											t3.agent_email,
											t3.agent_phone,
											t3.agent_designation,
											t3.agent_organization

											FROM tbl_payment t1

											JOIN tbl_pricing_plan t2
											ON t1.pricing_plan_id = t2.pricing_plan_id

											JOIN tbl_agent t3
											ON t1.agent_id = t3.agent_id");
					$statement->execute();
					$total = $statement->rowCount();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					?>
					<?php if(!$total): ?>
					<div class="error">Result Not Found</div>
					<?php else: ?>
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Serial</th>
								<th>Agent</th>
								<th>Payment Date</th>
								<th>Expire Date</th>
								<th>Transaction Id</th>
								<th>Pricing Plan and Amount</th>
								<th>Payment Status</th>
								<th>Action</th>
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
									<td>
										Id: <?php echo $row['agent_id']; ?><br>
										Name: <?php echo $row['agent_name']; ?><br>
										Email: <?php echo $row['agent_email']; ?><br>
										Phone: <?php echo $row['agent_phone']; ?><br>
										Designation: <?php echo $row['agent_designation']; ?><br>
										Organization: <?php echo $row['agent_organization']; ?>
									</td>
									<td><?php echo $row['payment_date']; ?></td>
									<td><?php echo $row['expire_date']; ?></td>
									<td><?php echo $row['txnid']; ?></td>
									<td><?php echo 'Plan: '.$row['pricing_plan_name'].'<br>Amount: $'.$row['paid_amount']; ?></td>
									<td>
										<?php
										if($row['payment_status']=='Pending'):
											echo '<span style="color:red;">'.$row['payment_status'].'</span>';
										else:
											echo '<span style="color:green;">'.$row['payment_status'].'</span>';
										endif;	
										?>
									</td>
									<td>
										<?php
										if($row['payment_status']=='Pending') {
											?>
											<a href="#" class="btn btn-danger btn-xs" data-href="seller-payment-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
											<?php
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
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>