<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$banner_login = $row['banner_login'];
}
?>

<?php
if(isset($_POST['form1'])) {
        
    if(empty($_POST['agent_email']) || empty($_POST['agent_password'])) {
        $error_message = 'Email and/or Password can not be empty.\\n';
    } else {
		
		$agent_email = strip_tags($_POST['agent_email']);
		$agent_password = strip_tags($_POST['agent_password']);

    	$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_email=?");
    	$statement->execute(array($agent_email));
    	$total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $agent_access = $row['agent_access'];
            $row_password = $row['agent_password'];
        }

        if($total==0) {
            $error_message .= 'Email Address does not match.\\n';
        } else {
        	if($agent_access == 0) {
        		$error_message .= 'Sorry! Your account is inactive. Please contact to the administrator.\\n';
        	} else {
        		if( $row_password != md5($agent_password) ) {
	                $error_message .= 'Password does not match.\\n';
	            } else {            
					$_SESSION['agent'] = $row;
	                header("location: ".BASE_URL.URL_DASHBOARD);
	            }
        	}
            
        }
    }
}
?>

<div class="banner-slider" style="background-image: url(<?php echo BASE_URL.'assets/uploads/'.$banner_login; ?>)">
	<div class="bg"></div>
	<div class="bannder-table">
		<div class="banner-text">
			<h1>Agent Login</h1>
		</div>
	</div>
</div>

<div class="login-area bg-area">
	<div class="container">
		<div class="row">

	
			<div class="col-md-offset-4 col-md-4">
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
							<div class="form-group">
								<label for="">Email Address</label>
								<input autocomplete="off" type="email" class="form-control" name="agent_email" placeholder="Email Address">
							</div>
							<div class="form-group">
								<label for="">Password</label>
								<input autocomplete="off" type="password" class="form-control" name="agent_password" placeholder="Password">
							</div>
							<button type="submit" class="btn btn-primary" name="form1">Login</button>
						</div>
					</form>
				</div>
			</div>
			
			<div class="login-here">
				<h3><i class="fa fa-user-circle-o"></i> New User? <a href="<?php echo BASE_URL.URL_REGISTRATION; ?>">Register Here</a></h3>
				<h3 style="margin-top:15px;"><i class="fa fa-user-circle-o"></i> Forget Password? <a href="<?php echo BASE_URL.URL_FORGET_PASSWORD; ?>">Click Here</a></h3>
			</div>
			
		</div>
	</div>
</div>
	
<?php require_once('footer.php'); ?>