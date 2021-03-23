<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: '.BASE_URL.URL_LOGOUT);
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE donor_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: '.BASE_URL.URL_LOGOUT);
		exit;
	} else {
		// Preventing one user deleting another user's data through url
		foreach ($result as $row) {
			$agent_id = $row['agent_id'];
		}
		if($agent_id != $_SESSION['agent']['agent_id']) {
			header('location: '.BASE_URL.URL_LOGOUT);
			exit;
		}
	}
}
// If agent is logged in, but admin make him inactive, then force logout this user.
$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=? AND agent_access=?");
$statement->execute(array($_SESSION['agent']['agent_id'],0));
$total = $statement->rowCount();
if($total) {
	header('location: '.BASE_URL.URL_LOGOUT);
	exit;
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

    $allowed_ext = 'jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF';
    $allowed_ext1 = 'jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF';

    $my_ext = get_ext($pdo,'photo');

    if($path!='') {
    	$ext_check = ext_check($pdo,$allowed_ext,$my_ext);
        if(!$ext_check) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file\n';
        }
    }

    if($valid == 1) {


    	// Featured Photo Change
    	if($path!='') {
    		$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE donor_id=?");
    		$statement->execute(array($_REQUEST['id']));
    		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    		foreach ($result as $row) {
    			$previous_photo = $row['photo'];
    		}    		
    		unlink('assets/uploads/donors/'.$previous_photo);
			$final_name = $_REQUEST['id'].$my_ext;
        	move_uploaded_file( $path_tmp, 'assets/uploads/donors/'.$final_name );
    	}
    	
	    // Updating data
	    if($path!=''):
	    	$statement = $pdo->prepare("UPDATE tbl_donor SET 
	    						name=?,
	        					description=?,
	        					profession=?,
	        					education=?,
	        					gender=?,
	        					date_of_birth=?,
	        					religion_id=?,
	        					blood_group_id=?,
	        					email=?,
	        					phone=?,
	        					website=?,
	        					address=?,
	        					city=?,
	        					country=?,
	        					state=?,
	        					zip_code=?,
	        					map=?,
	        					photo=?,
	        					facebook=?,
	        					twitter=?,
	        					linkedin=?,
	        					googleplus=?,
	        					pinterest=?,
	        					status=?
	    						WHERE donor_id=?
	    					");

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
	        					0,
	        					$_REQUEST['id']
	    					));
		else:
			$statement = $pdo->prepare("UPDATE tbl_donor SET 
	    						name=?,
	        					description=?,
	        					profession=?,
	        					education=?,
	        					gender=?,
	        					date_of_birth=?,
	        					religion_id=?,
	        					blood_group_id=?,
	        					email=?,
	        					phone=?,
	        					website=?,
	        					address=?,
	        					city=?,
	        					country=?,
	        					state=?,
	        					zip_code=?,
	        					map=?,
	        					facebook=?,
	        					twitter=?,
	        					linkedin=?,
	        					googleplus=?,
	        					pinterest=?,
	        					status=?
	    						WHERE donor_id=?
	    					");

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
	        					$_POST['facebook'],
	        					$_POST['twitter'],
	        					$_POST['linkedin'],
	        					$_POST['googleplus'],
	        					$_POST['pinterest'],
	        					0,
	        					$_REQUEST['id']
	    					));
		endif;
        
        $success_message .= "Donor is Updated successfully. But our admin will approve this update manually. So please wait for that.";
		
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE donor_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$name = $row['name'];
	$profession = $row['profession'];
	$education = $row['education'];
	$gender = $row['gender'];
	$date_of_birth = $row['date_of_birth'];
	$religion_id = $row['religion_id'];
	$blood_group_id = $row['blood_group_id'];
	$email = $row['email'];
	$phone = $row['phone'];
	$website = $row['website'];
	$address = $row['address'];
	$country = $row['country'];
	$state = $row['state'];
	$city = $row['city'];
	$zip_code = $row['zip_code'];
	$map = $row['map'];
	$facebook = $row['facebook'];
	$twitter = $row['twitter'];
	$linkedin = $row['linkedin'];
	$googleplus = $row['googleplus'];
	$pinterest = $row['pinterest'];
	$photo = $row['photo'];
	$description = $row['description'];
	$agent_id = $row['agent_id'];
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

					<h1>Edit Donor Information</h1>
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
								<form action="" method="post" enctype="multipart/form-data">
									<div class="form-row">
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Name *</label>
											<input autocomplete="off" type="text" class="form-control" name="name" value="<?php echo $name; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Profession *</label>
											<input autocomplete="off" type="text" class="form-control" name="profession" value="<?php echo $profession; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Education *</label>
											<input autocomplete="off" type="text" class="form-control" name="education" value="<?php echo $education; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Gender *</label>
											<select data-placeholder="Choose a gender" class="form-control chosen-select" name="gender">
												<option value="Male" <?php if($gender=='Male') {echo 'selected';} ?>>Male</option>
												<option value="Female" <?php if($gender=='Female') {echo 'selected';} ?>>Female</option>
											</select>
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Date of Birth *</label>
											<input autocomplete="off" type="text" class="form-control datepicker" name="date_of_birth" value="<?php echo $date_of_birth; ?>">
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
													<option value="<?php echo $row['religion_id']; ?>" <?php if($row['religion_id'] == $religion_id) {echo 'selected';} ?>><?php echo $row['religion_name']; ?></option>
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
													<option value="<?php echo $row['blood_group_id']; ?>" <?php if($row['blood_group_id'] == $blood_group_id) {echo 'selected';} ?>><?php echo $row['blood_group_name']; ?></option>
													<?php
												}
												?>
											</select>
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Email *</label>
											<input autocomplete="off" type="text" class="form-control" name="email" value="<?php echo $email; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Phone *</label>
											<input autocomplete="off" type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Website</label>
											<input autocomplete="off" type="text" class="form-control" name="website" value="<?php echo $website; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Address *</label>
											<input type="text" class="form-control" name="address"  value="<?php echo $address; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Country *</label>
											<input autocomplete=" *off" type="text" class="form-control" name="country" value="<?php echo $country; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">State</label>
											<input autocomplete="off" type="text" class="form-control" name="state" value="<?php echo $state; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">City *</label>
											<input autocomplete="off" type="text" class="form-control" name="city" value="<?php echo $city; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Zip Code *</label>
											<input autocomplete="off" type="text" class="form-control" name="zip_code" value="<?php echo $zip_code; ?>">
										</div>										
										<div class="form-group col-md-12 col-sm-12">
											<label for="">Map</label>
											<textarea class="form-control" name="map" placeholder="Map (iframe code)" style="height: 150px;"><?php echo $map; ?></textarea>
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Facebook</label>
											<input autocomplete="off" type="text" class="form-control" name="facebook" value="<?php echo $facebook; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Twitter</label>
											<input autocomplete="off" type="text" class="form-control" name="twitter" value="<?php echo $twitter; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Linkedin</label>
											<input autocomplete="off" type="text" class="form-control" name="linkedin" value="<?php echo $linkedin; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Google Plus</label>
											<input autocomplete="off" type="text" class="form-control" name="googleplus" value="<?php echo $googleplus; ?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Pinterest</label>
											<input autocomplete="off" type="text" class="form-control" name="pinterest" value="<?php echo $pinterest; ?>">
										</div>
									</div>
									<div class="form-group col-md-12">
										<label for="">Existing Featured Photo</label>
										<br><img src="assets/uploads/donors/<?php echo $photo; ?>" alt="" style="width:250px;">
								 	</div>

									<div class="form-group col-md-12">
										<label for="">New Featured Photo</label>
										<input type="file" class="form-control-file" name="photo">
								 	</div>

								 	<div class="clear"></div>
								 	
									
									<div class="form-group col-md-12">
										<label for="">Description</label>
										<textarea class="form-control" name="description"><?php echo $description; ?></textarea>
										<button type="submit" class="btn btn-primary" name="form1">Update information</button>
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


<?php require_once('footer.php'); ?>