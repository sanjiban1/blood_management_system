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

<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    $path = $_FILES['agent_photo']['name'];
    $path_tmp = $_FILES['agent_photo']['tmp_name'];

    $allowed_ext = 'jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF';

    $my_ext = get_ext($pdo,'agent_photo');

    if($path!='') {
    	$ext_check = ext_check($pdo,$allowed_ext,$my_ext);
        if(!$ext_check) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file\n';
        }
    } else {
    	$valid = 0;
        $error_message .= 'You must have to select a photo\n';
    }

    if($valid == 1) {

    	$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=?");
		$statement->execute(array($_SESSION['agent']['agent_id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$previous_photo = $row['agent_photo'];
		}
		if($previous_photo!='') {
			unlink('assets/uploads/agents/'.$previous_photo);
		}
		
		$final_name = $_SESSION['agent']['agent_id'].$my_ext;
    	move_uploaded_file( $path_tmp, 'assets/uploads/agents/'.$final_name );

		$statement = $pdo->prepare("UPDATE tbl_agent SET agent_photo=? WHERE agent_id=?");
		$statement->execute(array($final_name,$_SESSION['agent']['agent_id']));
			
    	$success_message = 'Profile Photo is updated successfully.';

    	$_SESSION['agent']['agent_photo'] = $final_name;
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

					<h1>Update Profile Photo</h1>

					<div class="login-area bg-area" style="padding-top: 0;margin-top: -30px;">
						<div class="row">
						
							<div class="col-md-12">
								
								<?php
								if($error_message != '') {
									echo "<script>alert('".$error_message."')</script>";
								}
								if($success_message != '') {
									echo "<script>alert('".$success_message."')</script>";
								}
								?>
								<div class="login-form">
									
									<form action="" method="post" enctype="multipart/form-data">

										<div class="form-row">

											<?php 
											$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=?");
											$statement->execute(array($_SESSION['agent']['agent_id']));
											$result = $statement->fetchAll(PDO::FETCH_ASSOC);
											foreach ($result as $row) {
												$previous_photo = $row['agent_photo'];
											}
											?>
											
											<div class="form-group col-md-6 col-sm-6">
												<label for="">Existing Photo</label><br>
												<?php if($previous_photo==''): ?>
													<img src="<?php echo BASE_URL; ?>assets/uploads/no-photo.jpg" alt="agent photo" style="width:200px;">
												<?php else: ?>
													<img src="<?php echo BASE_URL.'assets/uploads/agents/'.$_SESSION['agent']['agent_photo']; ?>" alt="agent photo" style="width:200px;">
												<?php endif; ?>
												
											</div>

											<div class="clear"></div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">New Photo *</label>
												<input type="file" name="agent_photo">
											</div>

											<div class="form-group col-md-12 col-sm-12">
												<button type="submit" class="btn btn-primary" name="form1">Update Photo</button>
											</div>
											
										</div>

									</form>

								</div>
							</div>		
								
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<?php require_once('footer.php'); ?>