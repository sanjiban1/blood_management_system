<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$banner_forget_password = $row['banner_forget_password'];
}
?>

<div class="banner-slider" style="background-image: url(<?php echo BASE_URL.'assets/uploads/'.$banner_forget_password; ?>)">
	<div class="bg"></div>
	<div class="bannder-table">
		<div class="banner-text">
			<h1>Reset Password Success Page</h1>
		</div>
	</div>
</div>

<div class="login-area bg-area">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="success">
					Password is reset successfully. You can now login. <br><br>
					<a href="<?php echo BASE_URL.'login.php'; ?>" style="text-decoration: underline;color: green;">Click here</a> to login
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>