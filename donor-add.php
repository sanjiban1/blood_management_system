<?php require_once('header.php'); ?>

<?php
// Check if the agent is logged in or not
if(!isset($_SESSION['agent'])) {
	header('location: '.BASE_URL.URL_LOGOUT);
	exit;
} else {
	// If agent is logged in, but admin make him inactive, then force logout this user.
	$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=? AND agent_access=?");
	$statement->execute(array($_SESSION['agent']['agent_id'],0));
	$total = $statement->rowCount();
	if($total) {
		header('location: '.BASE_URL.URL_LOGOUT);
		exit;
	}
}
?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;
	if(empty($_POST['name'])) {
		$valid = 0;
		$error_message .= 'Name can not be empty.\n';
	}
	if(empty($_POST['profession'])) {
		$valid = 0;
		$error_message .= 'Profession can not be empty.\n';
	}
	if(empty($_POST['education'])) {
		$valid = 0;
		$error_message .= 'Education can not be empty.\n';
	}
	if(empty($_POST['gender'])) {
		$valid = 0;
		$error_message .= 'You must have to select a gender.\n';
	}
	if(empty($_POST['date_of_birth'])) {
		$valid = 0;
		$error_message .= 'You must have to give date of birth.\n';
	}
	if(empty($_POST['religion_id'])) {
		$valid = 0;
		$error_message .= 'You must have to select a religion.\n';
	}
	if(empty($_POST['blood_group_id'])) {
		$valid = 0;
		$error_message .= 'You must have to select a blood group.\n';
	}
	if(empty($_POST['email'])) {
        $valid = 0;
        $error_message .= "Email can not be empty.\\n";
    } else {
    	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
	        $valid = 0;
	        $error_message .= 'Email address must be valid.\\n';
	    }
    }
    if(empty($_POST['phone'])) {
		$valid = 0;
		$error_message .= 'Phone can not be empty.\n';
	}
	if(empty($_POST['address'])) {
		$valid = 0;
		$error_message .= 'Address can not be empty.\n';
	}
	if(empty($_POST['country'])) {
		$valid = 0;
		$error_message .= 'Country can not be empty.\n';
	}
	if(empty($_POST['city'])) {
		$valid = 0;
		$error_message .= 'City can not be empty.\n';
	}
	if(empty($_POST['zip_code'])) {
		$valid = 0;
		$error_message .= 'Zip Code can not be empty.\n';
	}


	$path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    $next_id = get_ai_id($pdo,'tbl_donor');
    $allowed_ext = 'jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF';
    $allowed_ext1 = 'jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF';

    $my_ext = get_ext($pdo,'photo');

    if($path!='') {
    	$ext_check = ext_check($pdo,$allowed_ext,$my_ext);
        if(!$ext_check) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file\n';
        }
    } else {
    	$valid = 0;
        $error_message .= 'You must have to select a donor photo\n';
    }


    // Getting allowed donor numbers for this agent
	$statement = $pdo->prepare("SELECT * 
								FROM tbl_payment 
								WHERE agent_id=? AND payment_status=?
								ORDER BY id DESC
							");
	$statement->execute(array($_SESSION['agent']['agent_id'],'Completed'));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$pricing_plan_id = $row['pricing_plan_id'];
		break;
	}
	$statement = $pdo->prepare("SELECT * FROM tbl_pricing_plan WHERE pricing_plan_id=?");
	$statement->execute(array($pricing_plan_id));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$pricing_plan_item_allow = $row['pricing_plan_item_allow'];
	}

	$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE agent_id=?");
	$statement->execute(array($_SESSION['agent']['agent_id']));
	$total_car = $statement->rowCount();
	if($total_car >= $pricing_plan_item_allow) {
		$valid = 0;
		$error_message .= 'Your maximum number of allowed car entry is reached.\n';
	}


    if($valid == 1) {

    	$final_name1 = array();        


    	// Upload Featured Photo
    	$final_name = $next_id.$my_ext;
        move_uploaded_file( $path_tmp, 'assets/uploads/donors/'.$final_name );
        

	    // Adding data into the tbl_car table
        $statement = $pdo->prepare("
        					INSERT INTO tbl_donor 
        					(
        					name,
        					description,
        					profession,
        					education,
        					gender,
        					date_of_birth,
        					religion_id,
        					blood_group_id,
        					email,
        					phone,
        					website,
        					address,
        					city,
        					country,
        					state,
        					zip_code,
        					map,
        					photo,
        					facebook,
        					twitter,
        					linkedin,
        					googleplus,
        					pinterest,
        					agent_id,
        					status
        					) 

        					VALUES 
        					(?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?)");
        $statement->execute(array(
        					$_POST['name'],
        					$_POST['description'],
        					$_POST['profession'],
        					$_POST['education'],
        					$_POST['gender'],
        					$_POST['date_of_birth'],
        					$_POST['religion_id'],
        					$_POST['blood_group_id'],
        					$_POST['email'],
        					$_POST['phone'],
        					$_POST['website'],
        					$_POST['address'],
        					$_POST['city'],
        					$_POST['country'],
        					$_POST['state'],
        					$_POST['zip_code'],
        					$_POST['map'],
        					$final_name,
        					$_POST['facebook'],
        					$_POST['twitter'],
        					$_POST['linkedin'],
        					$_POST['googleplus'],
        					$_POST['pinterest'],
        					$_SESSION['agent']['agent_id'],
        					0
        				));

        $success_message .= "Donor is added successfully. But it will only become live after getting approved by admin.";

        unset($_POST['name']);
        unset($_POST['profession']);
        unset($_POST['education']);
        unset($_POST['date_of_birth']);
        unset($_POST['email']);
        unset($_POST['phone']);
        unset($_POST['website']);
        unset($_POST['address']);
        unset($_POST['country']);
        unset($_POST['state']);
        unset($_POST['city']);
        unset($_POST['zip_code']);
        unset($_POST['map']);
        unset($_POST['facebook']);
        unset($_POST['twitter']);
        unset($_POST['linkedin']);
        unset($_POST['googleplus']);
        unset($_POST['pinterest']);
        unset($_POST['description']);
		
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

					<h1>Add Donor</h1>

					
					<!-- Checking if this use has made payment -->
					<?php
					$allowed = 0;
					$today = date('Y-m-d');
					$statement = $pdo->prepare("SELECT * 
												FROM tbl_payment 
												WHERE agent_id=? AND payment_status=?
											");
					$statement->execute(array($_SESSION['agent']['agent_id'],'Completed'));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {
						if(($today >= $row['payment_date'])&&($today <= $row['expire_date'])) {
							$allowed = 1;
						}
					}
					?>

					<?php
					if($error_message != '') {
						echo "<script>alert('".$error_message."')</script>";
					}
					if($success_message != '') {
						echo "<script>alert('".$success_message."')</script>";
					}
					?>
					<?php if($allowed == 0): ?>
					<div class="error">You can only add car after making a payment. <a href="<?php echo BASE_URL; ?>payment.php" style="color:red;text-decoration:underline;">Go here</a> to make a payment.</div>
					<?php else: ?>
					<div style="margin-bottom: 20px;">* = Required Fields</div>
					<div class="add-car-area">
						<div class="row">
							<div class="information-form">
								<form action="" method="post" enctype="multipart/form-data">
									<div class="form-row">
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Name *</label>
											<input autocomplete="off" type="text" class="form-control" name="name" value="<?php if(isset($_POST['name'])) {echo $_POST['name'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Profession *</label>
											<input autocomplete="off" type="text" class="form-control" name="profession" value="<?php if(isset($_POST['profession'])) {echo $_POST['profession'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Education *</label>
											<input autocomplete="off" type="text" class="form-control" name="education" value="<?php if(isset($_POST['education'])) {echo $_POST['education'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Gender *</label>
											<select data-placeholder="Choose a gender" class="form-control chosen-select" name="gender">
												<option value="Male" selected>Male</option>
												<option value="Female">Female</option>
											</select>
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Date of Birth *</label>
											<input autocomplete="off" type="text" class="form-control datepicker" name="date_of_birth" value="1990-01-01">
										</div>				
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Religion *</label>
											<select data-placeholder="Choose a religion" class="form-control chosen-select" name="religion_id">
												<?php
												$statement = $pdo->prepare("SELECT * FROM tbl_religion");
												$statement->execute();
												$result = $statement->fetchAll(PDO::FETCH_ASSOC);
												foreach ($result as $row) {
													?>
													<option></option>
													<option value="<?php echo $row['religion_id']; ?>"><?php echo $row['religion_name']; ?></option>
													<?php
												}
												?>
											</select>
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Blood Group *</label>
											<select data-placeholder="Choose a blood group" class="form-control chosen-select" name="blood_group_id">
												<?php
												$statement = $pdo->prepare("SELECT * FROM tbl_blood_group");
												$statement->execute();
												$result = $statement->fetchAll(PDO::FETCH_ASSOC);
												foreach ($result as $row) {
													?>
													<option></option>
													<option value="<?php echo $row['blood_group_id']; ?>"><?php echo $row['blood_group_name']; ?></option>
													<?php
												}
												?>
											</select>
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Email *</label>
											<input autocomplete="off" type="text" class="form-control" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Phone *</label>
											<input autocomplete="off" type="text" class="form-control" name="phone" value="<?php if(isset($_POST['phone'])) {echo $_POST['phone'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Website</label>
											<input autocomplete="off" type="text" class="form-control" name="website" value="<?php if(isset($_POST['website'])) {echo $_POST['website'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Address *</label>
											<input type="text" class="form-control" name="address"  value="<?php if(isset($_POST['address'])) {echo $_POST['address'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Country *</label>
											<input autocomplete=" *off" type="text" class="form-control" name="country" value="<?php if(isset($_POST['country'])) {echo $_POST['country'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">State</label>
											<input autocomplete="off" type="text" class="form-control" name="state" value="<?php if(isset($_POST['state'])) {echo $_POST['state'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">City *</label>
											<input autocomplete="off" type="text" class="form-control" name="city" value="<?php if(isset($_POST['city'])) {echo $_POST['city'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Zip Code *</label>
											<input autocomplete="off" type="text" class="form-control" name="zip_code" value="<?php if(isset($_POST['zip_code'])) {echo $_POST['zip_code'];} ?>">
										</div>										
										<div class="form-group col-md-12 col-sm-12">
											<label for="">Map</label>
											<textarea class="form-control" name="map" placeholder="Map (iframe code)" style="height: 150px;"><?php if(isset($_POST['map'])) {echo $_POST['map'];} ?></textarea>
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Facebook</label>
											<input autocomplete="off" type="text" class="form-control" name="facebook" value="<?php if(isset($_POST['facebook'])) {echo $_POST['facebook'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Twitter</label>
											<input autocomplete="off" type="text" class="form-control" name="twitter" value="<?php if(isset($_POST['twitter'])) {echo $_POST['twitter'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Linkedin</label>
											<input autocomplete="off" type="text" class="form-control" name="linkedin" value="<?php if(isset($_POST['linkedin'])) {echo $_POST['linkedin'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Google Plus</label>
											<input autocomplete="off" type="text" class="form-control" name="googleplus" value="<?php if(isset($_POST['googleplus'])) {echo $_POST['googleplus'];} ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Pinterest</label>
											<input autocomplete="off" type="text" class="form-control" name="pinterest" value="<?php if(isset($_POST['pinterest'])) {echo $_POST['pinterest'];} ?>">
										</div>
									</div>
									
									<div class="form-group col-md-12">
										<label for="">Photo *</label>
										<input type="file" class="form-control-file" name="photo">
								 	</div>
								 	
									<div class="form-group col-md-12">
										<label for="">Description</label>
										<textarea class="form-control" name="description"><?php if(isset($_POST['description'])) {echo $_POST['description'];} ?></textarea>
										<button type="submit" class="btn btn-primary" name="form1">Add Donor</button>
									</div>

								</form>

							</div>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>


<?php require_once('footer.php'); ?>