<?php require_once('header.php'); ?>

<?php
if ( (!isset($_REQUEST['email'])) || (isset($_REQUEST['token'])) )
{
	$var = 1;

	// check if the token is correct and match with database.
	$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_email=?");
	$statement->execute(array($_REQUEST['email']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		if($_REQUEST['token'] != $row['agent_token']) {
			header('location: '.BASE_URL);
			exit;
		}
	}

	// everything is correct. now activate the user removing token value from database.
	if($var != 0)
	{
	    $statement = $pdo->prepare("UPDATE tbl_agent SET agent_token=?, agent_time=?, agent_access=? WHERE agent_email=?");
	    $statement->execute(array('','',1,$_GET['email']));

	    $success_message = '<p style="color:green;">Your email is verified successfully. You can now login to our website.</p><p><a href="'.BASE_URL.URL_LOGIN.'" style="color:#167ac6;font-weight:bold;">Click here to login</a></p>';		
	}
}
?>

<div class="banner-slider" style="background-image: url(img/banner.jpg)">
	<div class="bg"></div>
	<div class="bannder-table">
		<div class="banner-text">
			<h1>Registration Successful</h1>
		</div>
	</div>
</div>

<div class="login-area bg-area">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-4 col-md-5">
				<div class="login-form">
					<?php 
						echo $error_message;
						echo $success_message;
					?>
				</div>
			</div>
		</div>
	</div>
</div>
	
<?php require_once('footer.php'); ?>