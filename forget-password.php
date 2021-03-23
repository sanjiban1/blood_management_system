<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$banner_forget_password = $row['banner_forget_password'];
}
?>


<?php
if(isset($_POST['form1'])) {

	$valid = 1;
        
    if(empty($_POST['seller_email'])) {
        $valid = 0;
        $error_message .= "Email can not be empty.\\n";
    } else {
    	if (filter_var($_POST['seller_email'], FILTER_VALIDATE_EMAIL) === false) {
	        $valid = 0;
	        $error_message .= 'Email address must be valid.\\n';
	    } else {
	    	$statement = $pdo->prepare("SELECT * FROM tbl_seller WHERE seller_email=?");
	    	$statement->execute(array($_POST['seller_email']));
	    	$total = $statement->rowCount();						
	    	if(!$total) {
	    		$valid = 0;
	        	$error_message .= 'You email address is not found in our system.\\n';
	    	}
	    }
    }

    if($valid == 1) {

    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$forget_password_message = $row['forget_password_message'];
    	}

    	$token = md5(rand());
    	$now = time();

		$statement = $pdo->prepare("UPDATE tbl_seller SET seller_token=?,seller_time=? WHERE seller_email=?");
		$statement->execute(array($token,$now,$_POST['seller_email']));
		
		$message = '<p>To reset your password, please <a href="'.BASE_URL.'reset-password.php?email='.$_POST['seller_email'].'&token='.$token.'">click here</a> and enter a new password for your account';
		
		$to      = $_POST['seller_email'];
		$subject = "PASSWORD RESET REQUEST - " . BASE_URL;
		$headers = "From: noreply@" . BASE_URL . "\r\n" .
				   "Reply-To: noreply@" . BASE_URL . "\r\n" .
				   "X-Mailer: PHP/" . phpversion() . "\r\n" . 
				   "MIME-Version: 1.0\r\n" . 
				   "Content-Type: text/html; charset=ISO-8859-1\r\n";

		mail($to, $subject, $message, $headers);

		$success_message = $forget_password_message;
    }
}
?>

<div class="banner-slider" style="background-image: url(<?php echo BASE_URL.'assets/uploads/'.$banner_forget_password; ?>)">
	<div class="bg"></div>
	<div class="bannder-table">
		<div class="banner-text">
			<h1>Forget Password</h1>
		</div>
	</div>
</div>

<div class="login-area bg-area">
	<div class="container">
		<div class="row">
			<?php
			if($error_message != '') {
				echo "<script>alert('".$error_message."')</script>";
			}
			if($success_message != '') {
				echo "<script>alert('".$success_message."')</script>";
			}
			?>
			<div class="col-md-offset-4 col-md-4">
				<div class="login-form">
					<form action="" method="post">
						<div class="form-row">
							<div class="form-group">
								<label for="">Email Address</label>
								<input autocomplete="off" type="email" class="form-control" placeholder="Enter Email Address" name="seller_email">
							</div>
							<button type="submit" class="btn btn-primary" name="form1">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>