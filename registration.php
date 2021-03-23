<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$banner_registration = $row['banner_registration'];
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

    if(empty($_POST['agent_email'])) {
        $valid = 0;
        $error_message .= "Email can not be empty.\\n";
    } else {
    	if (filter_var($_POST['agent_email'], FILTER_VALIDATE_EMAIL) === false) {
	        $valid = 0;
	        $error_message .= 'Email address must be valid.\\n';
	    } else {
	    	$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_email=?");
	    	$statement->execute(array($_POST['agent_email']));
	    	$total = $statement->rowCount();							
	    	if($total) {
	    		$valid = 0;
	        	$error_message .= 'Email address already exists.\\n';
	    	}
	    }
    }

    if(empty($_POST['agent_phone'])) {
        $valid = 0;
        $error_message .= "Phone Number can not be empty.\\n";
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

    if( empty($_POST['agent_password']) || empty($_POST['agent_re_password']) ) {
        $valid = 0;
        $error_message .= "Password can not be empty.\\n";
    }

    if( !empty($_POST['agent_password']) && !empty($_POST['agent_re_password']) ) {
    	if($_POST['agent_password'] != $_POST['agent_re_password']) {
	    	$valid = 0;
	        $error_message .= "Passwords do not match.\\n";	
    	}        
    }

    if($valid == 1) {

    	$token = md5(uniqid(rand(), true));
    	$now = time();

		// saving into the database
		$statement = $pdo->prepare("INSERT INTO tbl_agent (agent_name,agent_designation,agent_organization,agent_email,agent_phone,agent_address, agent_city,agent_state,agent_country,agent_zip_code,agent_password,agent_token,agent_time,agent_access) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$statement->execute(array($_POST['agent_name'],$_POST['agent_designation'],$_POST['agent_organization'],$_POST['agent_email'],$_POST['agent_phone'],$_POST['agent_address'],$_POST['agent_city'],$_POST['agent_state'],$_POST['agent_country'],$_POST['agent_zip_code'],md5($_POST['agent_password']),$token,$now,0));

		// Send email for confirmation of the account
        $to = $_POST['agent_email'];
        
        $subject = 'Registration Email Confirmation for ' . BASE_URL;
        $verify_link = BASE_URL.'verify.php?email='.$to.'&token='.$token;
        $message = '
Thank you for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.<br><br>

Please click this link to activate your account:
<a href="'.$verify_link.'">'.$verify_link.'</a>';

		$headers = "From: noreply@" . BASE_URL . "\r\n" .
				   "Reply-To: noreply@" . BASE_URL . "\r\n" .
				   "X-Mailer: PHP/" . phpversion() . "\r\n" . 
				   "MIME-Version: 1.0\r\n" . 
				   "Content-Type: text/html; charset=ISO-8859-1\r\n";
				   
        mail($to, $subject, $message, $headers); // Send the email

    	unset($_POST['agent_name']);
    	unset($_POST['agent_designation']);
    	unset($_POST['agent_organization']);
    	unset($_POST['agent_email']);
    	unset($_POST['agent_phone']);
    	unset($_POST['agent_address']);
    	unset($_POST['agent_city']);
    	unset($_POST['agent_state']);
    	unset($_POST['agent_country']);
    	unset($_POST['agent_zip_code']);

    	$success_message = 'Your registration is completed. Please check your email address to follow the process to confirm your registration.';
    }
}
?>

<div class="banner-slider" style="background-image: url(<?php echo BASE_URL.'assets/uploads/'.$banner_registration; ?>)">
	<div class="bg"></div>
	<div class="bannder-table">
		<div class="banner-text">
			<h1>Agent Registration</h1>
		</div>
	</div>
</div>

<div class="login-area bg-area">
	<div class="container">
		<div class="row">
		
			<div class="col-md-offset-2 col-md-8">
				
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
							
							<div class="form-group  col-md-6">
								<label for="">Full Name *</label>
								<input type="text" class="form-control" name="agent_name" placeholder="Full Name" value="<?php if(isset($_POST['agent_name'])){echo $_POST['agent_name'];} ?>">
							</div>

							<div class="form-group  col-md-6">
								<label for="">Designation *</label>
								<input type="text" class="form-control" name="agent_designation" placeholder="Designation" value="<?php if(isset($_POST['agent_designation'])){echo $_POST['agent_designation'];} ?>">
							</div>

							<div class="form-group  col-md-6">
								<label for="">Organization *</label>
								<input type="text" class="form-control" name="agent_organization" placeholder="Organization" value="<?php if(isset($_POST['agent_organization'])){echo $_POST['agent_organization'];} ?>">
							</div>

							<div class="form-group  col-md-6">
								<label for="">Email Address *</label>
								<input type="email" class="form-control" name="agent_email" placeholder="Email Address" value="<?php if(isset($_POST['agent_email'])){echo $_POST['agent_email'];} ?>">
							</div>

							<div class="form-group  col-md-6">
								<label for="">Phone *</label>
								<input type="text" class="form-control" name="agent_phone" placeholder="Phone Number" value="<?php if(isset($_POST['agent_phone'])){echo $_POST['agent_phone'];} ?>">
							</div>

							<div class="form-group  col-md-6">
								<label for="">Address *</label>
								<input type="text" class="form-control" name="agent_address" placeholder="Address" value="<?php if(isset($_POST['agent_address'])){echo $_POST['agent_address'];} ?>">
							</div>

							<div class="form-group  col-md-6">
								<label for="">Country *</label>
								<input type="text" class="form-control" name="agent_country" placeholder="Country" value="<?php if(isset($_POST['agent_country'])){echo $_POST['agent_country'];} ?>">
							</div>

							<div class="form-group  col-md-6">
								<label for="">State</label>
								<input type="text" class="form-control" name="agent_state" placeholder="State" value="<?php if(isset($_POST['agent_state'])){echo $_POST['agent_state'];} ?>">
							</div>

							<div class="form-group  col-md-6">
								<label for="">City *</label>
								<input type="text" class="form-control" name="agent_city" placeholder="City" value="<?php if(isset($_POST['agent_city'])){echo $_POST['agent_city'];} ?>">
							</div>

							<div class="form-group  col-md-6">
								<label for="">Zip Code *</label>
								<input type="text" class="form-control" name="agent_zip_code" placeholder="Zip Code" value="<?php if(isset($_POST['agent_zip_code'])){echo $_POST['agent_zip_code'];} ?>">
							</div>							
							
							<div class="form-group  col-md-6">
								<label for="">Password *</label>
								<input type="password" class="form-control" name="agent_password" placeholder="Password">
							</div>

							<div class="form-group  col-md-6">
								<label for="">Retype Password *</label>
								<input type="password" class="form-control" name="agent_re_password" placeholder="Retype Password">
							</div>
							
							<button type="submit" class="btn btn-primary" name="form1">Sign Up</button>
							
						</div>

					</form>

				</div>
			</div>

			<div class="login-here">
				<h3><i class="fa fa-user-circle-o"></i> Already a Member? <a href="<?php echo BASE_URL.URL_LOGIN; ?>">Login Here</a></h3>
			</div>			
				
		</div>
	</div>
</div>
	
<?php require_once('footer.php'); ?>