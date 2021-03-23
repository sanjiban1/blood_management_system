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

    if(empty($_POST['agent_name'])) {
        $valid = 0;
        $error_message .= "Name can not be empty.\\n";
    }

    if(empty($_POST['agent_designation'])) {
        $valid = 0;
        $error_message .= "Designation can not be empty.\\n";
    }

    if(empty($_POST['agent_organization'])) {
        $valid = 0;
        $error_message .= "Organization can not be empty.\\n";
    }

    if(empty($_POST['agent_phone'])) {
        $valid = 0;
        $error_message .= "Phone can not be empty.\\n";
    }

    if(empty($_POST['agent_address'])) {
        $valid = 0;
        $error_message .= "Address can not be empty.\\n";
    }

    if(empty($_POST['agent_country'])) {
        $valid = 0;
        $error_message .= "Country can not be empty.\\n";
    }

    if(empty($_POST['agent_city'])) {
        $valid = 0;
        $error_message .= "City can not be empty.\\n";
    }

    if(empty($_POST['agent_zip_code'])) {
        $valid = 0;
        $error_message .= "Zip Code can not be empty.\\n";
    }

    
    if( !(empty($_POST['agent_password']) && empty($_POST['agent_re_password'])) ) {
        if($_POST['agent_password'] != $_POST['agent_re_password']) {
	    	$valid = 0;
	        $error_message .= "Passwords do not match. Try again.\\n";	
    	}
    }

    if($valid == 1) {

		// update data into the database
		if(empty($_POST['agent_password'])) {
			$statement = $pdo->prepare("UPDATE tbl_agent SET agent_name=?, agent_designation=?, agent_organization=?, agent_description=?, agent_phone=?, agent_website=?, agent_address=?, agent_city=?, agent_state=?, agent_country=?, agent_zip_code=?, agent_map=?, agent_facebook=?, agent_twitter=?, agent_linkedin=?, agent_googleplus=?, agent_pinterest=? WHERE agent_id=?");
			$statement->execute(array($_POST['agent_name'],$_POST['agent_designation'],$_POST['agent_organization'],$_POST['agent_description'],$_POST['agent_phone'],$_POST['agent_website'],$_POST['agent_address'],$_POST['agent_city'],$_POST['agent_state'],$_POST['agent_country'],$_POST['agent_zip_code'],$_POST['agent_map'],$_POST['agent_facebook'],$_POST['agent_twitter'],$_POST['agent_linkedin'],$_POST['agent_googleplus'],$_POST['agent_pinterest'],$_SESSION['agent']['agent_id']));	
		} else {
			$statement = $pdo->prepare("UPDATE tbl_agent SET agent_name=?, agent_designation=?, agent_organization=?, agent_description=?, agent_phone=?, agent_website=?, agent_address=?, agent_city=?, agent_state=?, agent_country=?, agent_zip_code=?, agent_map=?, agent_facebook=?, agent_twitter=?, agent_linkedin=?, agent_googleplus=?, agent_pinterest=?,agent_password=? WHERE agent_id=?");
			$statement->execute(array($_POST['agent_name'],$_POST['agent_designation'],$_POST['agent_organization'],$_POST['agent_description'],$_POST['agent_phone'],$_POST['agent_website'],$_POST['agent_address'],$_POST['agent_city'],$_POST['agent_state'],$_POST['agent_country'],$_POST['agent_zip_code'],$_POST['agent_map'],$_POST['agent_facebook'],$_POST['agent_twitter'],$_POST['agent_linkedin'],$_POST['agent_googleplus'],$_POST['agent_pinterest'],md5($_POST['agent_password']),$_SESSION['agent']['agent_id']));
			
			$_SESSION['agent']['agent_password'] = md5($_POST['agent_password']);
		}

    	$success_message = 'Profile Information is updated successfully.';

    	$_SESSION['agent']['agent_name'] = $_POST['agent_name'];
    	$_SESSION['agent']['agent_designation'] = $_POST['agent_designation'];
    	$_SESSION['agent']['agent_organization'] = $_POST['agent_organization'];
    	$_SESSION['agent']['agent_description'] = $_POST['agent_description'];
    	$_SESSION['agent']['agent_phone'] = $_POST['agent_phone'];
    	$_SESSION['agent']['agent_website'] = $_POST['agent_website'];
    	$_SESSION['agent']['agent_address'] = $_POST['agent_address'];
    	$_SESSION['agent']['agent_city'] = $_POST['agent_city'];
    	$_SESSION['agent']['agent_state'] = $_POST['agent_state'];
    	$_SESSION['agent']['agent_country'] = $_POST['agent_country'];
    	$_SESSION['agent']['agent_zip_code'] = $_POST['agent_zip_code'];
    	$_SESSION['agent']['agent_map'] = $_POST['agent_map'];
    	$_SESSION['agent']['agent_facebook'] = $_POST['agent_facebook'];
    	$_SESSION['agent']['agent_twitter'] = $_POST['agent_twitter'];
    	$_SESSION['agent']['agent_linkedin'] = $_POST['agent_linkedin'];
    	$_SESSION['agent']['agent_googleplus'] = $_POST['agent_googleplus'];
    	$_SESSION['agent']['agent_pinterest'] = $_POST['agent_pinterest'];
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

					<h1>Update Profile Information</h1>

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
									
									<form action="" method="post">

										<div class="form-row">
											
											<div class="form-group col-md-6 col-sm-6">
												<label for="">Name *</label>
												<input type="text" class="form-control" name="agent_name" value="<?php echo $_SESSION['agent']['agent_name']; ?>">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Designation *</label>
												<input type="text" class="form-control" name="agent_designation" value="<?php echo $_SESSION['agent']['agent_designation']; ?>">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Organization *</label>
												<input type="text" class="form-control" name="agent_organization" value="<?php echo $_SESSION['agent']['agent_organization']; ?>">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Email Address (Can not be changed)</label>
												<input type="email" class="form-control" name="agent_email" placeholder="Email Address" value="<?php echo $_SESSION['agent']['agent_email']; ?>" disabled>
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Phone *</label>
												<input type="text" class="form-control" name="agent_phone" value="<?php echo $_SESSION['agent']['agent_phone']; ?>">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Website </label>
												<input type="text" class="form-control" name="agent_website" value="<?php echo $_SESSION['agent']['agent_website']; ?>">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Address *</label>
												<input type="text" class="form-control" name="agent_address" value="<?php echo $_SESSION['agent']['agent_address']; ?>">
											</div>											

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Country *</label>
												<input type="text" class="form-control" name="agent_country" value="<?php echo $_SESSION['agent']['agent_country']; ?>">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">State</label>
												<input type="text" class="form-control" name="agent_state" value="<?php echo $_SESSION['agent']['agent_state']; ?>">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">City *</label>
												<input type="text" class="form-control" name="agent_city" value="<?php echo $_SESSION['agent']['agent_city']; ?>">
											</div>
											

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Zip Code *</label>
												<input type="text" class="form-control" name="agent_zip_code" value="<?php echo $_SESSION['agent']['agent_zip_code']; ?>">
											</div>

											<div class="clear"></div>

											<div class="form-group col-md-12 col-sm-12">
												<label for="">Map</label>
												<textarea name="agent_map" class="form-control" cols="30" rows="10"><?php echo $_SESSION['agent']['agent_map']; ?></textarea>
											</div>

											<div class="clear"></div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Facebook</label>
												<input type="text" class="form-control" name="agent_facebook" value="<?php echo $_SESSION['agent']['agent_facebook']; ?>">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Twitter</label>
												<input type="text" class="form-control" name="agent_twitter" value="<?php echo $_SESSION['agent']['agent_twitter']; ?>">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">LinkedIn</label>
												<input type="text" class="form-control" name="agent_linkedin" value="<?php echo $_SESSION['agent']['agent_linkedin']; ?>">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Google Plus</label>
												<input type="text" class="form-control" name="agent_googleplus" value="<?php echo $_SESSION['agent']['agent_googleplus']; ?>">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Pinterest</label>
												<input type="text" class="form-control" name="agent_pinterest" value="<?php echo $_SESSION['agent']['agent_pinterest']; ?>">
											</div>
											
											<div class="form-group col-md-6 col-sm-6">
												<label for="">Password</label>
												<input type="password" class="form-control" name="agent_password" placeholder="Password">
											</div>

											<div class="form-group col-md-6 col-sm-6">
												<label for="">Retype Password</label>
												<input type="password" class="form-control" name="agent_re_password" placeholder="Retype Password">
											</div>

											<div class="form-group col-md-12 col-sm-12">
												<textarea class="form-control" name="agent_description"><?php echo $_SESSION['agent']['agent_description']; ?></textarea>
											</div>

											<div class="form-group col-md-12 col-sm-12">
												<button type="submit" class="btn btn-primary" name="form1">Update Information</button>
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