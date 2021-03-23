<?php require_once('header.php'); ?>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) 
	{
		$banner_agent = $row['banner_agent'];
	}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: index.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0 ) {
		header('location: index.php');
		exit;
	}
}
?>
<?php							
foreach ($result as $row) {
	$agent_name = $row['agent_name'];
	$agent_designation = $row['agent_designation'];
	$agent_organization = $row['agent_organization'];
	$agent_description = $row['agent_description'];
	$agent_email = $row['agent_email'];
	$agent_phone = $row['agent_phone'];
	$agent_website = $row['agent_website'];
	$agent_address = $row['agent_address'];
	$agent_city = $row['agent_city'];
	$agent_state = $row['agent_state'];
	$agent_country = $row['agent_country'];
	$agent_zip_code = $row['agent_zip_code'];
	$agent_map = $row['agent_map'];
	$agent_photo = $row['agent_photo'];
	$agent_facebook = $row['agent_facebook'];
	$agent_twitter = $row['agent_twitter'];
	$agent_linkedin = $row['agent_linkedin'];
	$agent_googleplus = $row['agent_googleplus'];
	$agent_pinterest = $row['agent_pinterest'];
	$agent_access = $row['agent_access'];
}
if( $agent_access == 0 ) {
	header('location: index.php');
	exit;
}
?>

<div class="banner-slider" style="background-image: url(<?php echo BASE_URL.'assets/uploads/'.$banner_agent; ?>)">
	<div class="bg"></div>
	<div class="bannder-table">
		<div class="banner-text">
			<h1>Agent Profile</h1>
		</div>
	</div>
</div>

<div class="agent-profile">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-4">
				<div class="agent-leftbar">
					<div class="agent-profile-item">
						<?php if($agent_photo==''): ?>
							<div class="agent-image" style="background-image: url(<?php echo BASE_URL; ?>assets/uploads/no-photo.jpg)"></div>
						<?php else: ?>
							<div class="agent-image" style="background-image: url(<?php echo BASE_URL.'assets/uploads/agents/'.$agent_photo; ?>)"></div>
						<?php endif; ?>
						
						<div class="agent-leftbar-info">
							<h2><?php echo $agent_name; ?></h2>
							<ul>
								<li>Designation: <span><?php echo $agent_designation; ?></span></li>
								<li>Organization: <span><?php echo $agent_organization; ?></span></li>
							</ul>
							<div class="agent-leftbar-social">
								<ul>
									<?php
										if($agent_facebook!='') {
											echo '<li><a href="'.$agent_facebook.'"><i class="fa fa-facebook"></i></a></li>';
										}
										if($agent_twitter!='') {
											echo '<li><a href="'.$agent_twitter.'"><i class="fa fa-twitter"></i></a></li>';
										}
										if($agent_linkedin!='') {
											echo '<li><a href="'.$agent_linkedin.'"><i class="fa fa-linkedin"></i></a></li>';
										}
										if($agent_googleplus!='') {
											echo '<li><a href="'.$agent_googleplus.'"><i class="fa fa-google-plus"></i></a></li>';
										}
										if($agent_pinterest!='') {
											echo '<li><a href="'.$agent_pinterest.'"><i class="fa fa-pinterest"></i></a></li>';
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8 col-sm-8">
				<div class="agent-description">
					
					<h3>Details</h3>
					<div class="agent-description-list">
						<table class="table table-bordered">
							<tr>
								<td>Email: </td>
								<td><?php echo $agent_email; ?></td>
							</tr>
							<tr>
								<td>Phone: </td>
								<td><?php echo $agent_phone; ?></td>
							</tr>
							<tr>
								<td>Website: </td>
								<td>
									<?php
									if($agent_website!=''):
										echo $agent_website;
									else:
										echo '---';
									endif;
									?>
								</td>
							</tr>
							<tr>
								<td>Address: </td>
								<td><?php echo $agent_address; ?></td>
							</tr>
							<tr>
								<td>Country: </td>
								<td><?php echo $agent_country; ?></td>
							</tr>
							<tr>
								<td>State: </td>
								<td>
									<?php
									if($agent_state!=''):
										echo $agent_state;
									else:
										echo '---';
									endif;
									?>
								</td>
							</tr>
							<tr>
								<td>City: </td>
								<td><?php echo $agent_city; ?></td>
							</tr>
							<tr>
								<td>Zip Code: </td>
								<td><?php echo $agent_zip_code; ?></td>
							</tr>
							<tr>
								<td>Map: </td>
								<td>
									<?php
									if($agent_map!=''):
										echo $agent_map;
									else:
										echo '---';
									endif;
									?>
								</td>
							</tr>
						</table>
					</div>
					<h3>Description</h3>
					<p class="description">
						<?php echo nl2br($agent_description); ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>