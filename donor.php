<?php require_once('header.php'); ?>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) 
	{
		$banner_donor = $row['banner_donor'];
	}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: index.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE donor_id=?");
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
	$name = $row['name'];
	$description = $row['description'];
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
	$city = $row['city'];
	$country = $row['country'];
	$state = $row['state'];
	$zip_code = $row['zip_code'];
	$map = $row['map'];
	$photo = $row['photo'];
	$facebook = $row['facebook'];
	$twitter = $row['twitter'];
	$linkedin = $row['linkedin'];
	$googleplus = $row['googleplus'];
	$pinterest = $row['pinterest'];
	$agent_id = $row['agent_id'];
	$status = $row['status'];
}
if( $status == 0 ) {
	header('location: index.php');
	exit;
}

$statement = $pdo->prepare("SELECT * FROM tbl_blood_group WHERE blood_group_id=?");
$statement->execute(array($blood_group_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$blood_group_name = $row['blood_group_name'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_religion WHERE religion_id=?");
$statement->execute(array($religion_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$religion_name = $row['religion_name'];
}
						
$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=?");
$statement->execute(array($agent_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$agent_name = $row['agent_name'];
	$agent_designation = $row['agent_designation'];
	$agent_organization = $row['agent_organization'];
	$agent_email = $row['agent_email'];
	$agent_phone = $row['agent_phone'];
}
?>

<div class="banner-slider" style="background-image: url(<?php echo BASE_URL.'assets/uploads/'.$banner_donor; ?>);">
	<div class="bg"></div>
	<div class="bannder-table">
		<div class="banner-text">
			<h1>Donor Detail</h1>
		</div>
	</div>
</div>

<div class="donner-profile">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-4">
				<div class="donner-leftbar">
					<div class="donner-profile-item">
						<div class="donner-image" style="background-image: url(<?php echo BASE_URL.'assets/uploads/donors/'.$photo; ?>)"></div>
						<div class="donner-leftbar-info">
							<h2><?php echo $name; ?></h2>
							<h4>Blood Group: <span><?php echo $blood_group_name; ?></span> </h4>
							<div class="donner-leftbar-social">
								<ul>
									<?php
										if($facebook!='') {
											echo '<li><a href="'.$facebook.'"><i class="fa fa-facebook"></i></a></li>';
										}
										if($twitter!='') {
											echo '<li><a href="'.$twitter.'"><i class="fa fa-twitter"></i></a></li>';
										}
										if($linkedin!='') {
											echo '<li><a href="'.$linkedin.'"><i class="fa fa-linkedin"></i></a></li>';
										}
										if($googleplus!='') {
											echo '<li><a href="'.$googleplus.'"><i class="fa fa-google-plus"></i></a></li>';
										}
										if($pinterest!='') {
											echo '<li><a href="'.$pinterest.'"><i class="fa fa-pinterest"></i></a></li>';
										}
									?>
								</ul>
							</div>
						</div>
					</div>
					<div class="donner-contact-form">
					<h3>Message to Donor</h3>
					<?php
// After form submit checking everything for email sending
if(isset($_POST['form1']))
{
	$error_message = '';
	$success_message = '';
	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) 
	{
		$donor_email_subject = $row['donor_email_subject'];
		$donor_email_thank_you_message = $row['donor_email_thank_you_message'];
	}

    $valid = 1;

    if(empty($_POST['visitor_name']))
    {
        $valid = 0;
        $error_message .= 'Please enter your name.\n';
    }

    if(empty($_POST['visitor_email']))
    {
        $valid = 0;
        $error_message .= 'Please enter your email address.\n';
    }
    else
    {
    	// Email validation check
        if(!filter_var($_POST['visitor_email'], FILTER_VALIDATE_EMAIL))
        {
            $valid = 0;
            $error_message .= 'Please enter a valid email address.\n';
        }
    }

    if(empty($_POST['visitor_message']))
    {
        $valid = 0;
        $error_message .= 'Please enter your message.\n';
    }

    if($valid == 1)
    {
		
		$visitor_name = strip_tags($_POST['visitor_name']);
		$visitor_email = strip_tags($_POST['visitor_email']);
		$visitor_phone = strip_tags($_POST['visitor_phone']);
		$visitor_message = strip_tags($_POST['visitor_message']);

        // sending email
        $to = $donor_email;
        $subject = $donor_email_subject;
		$message = '
<html><body>
<table>
<tr>
<td>Name</td>
<td>'.$visitor_name.'</td>
</tr>
<tr>
<td>Email</td>
<td>'.$visitor_email.'</td>
</tr>
<tr>
<td>Phone</td>
<td>'.$visitor_phone.'</td>
</tr>
<tr>
<td>Message</td>
<td>'.nl2br($visitor_message).'</td>
</tr>
</table>
</body></html>
';
		$headers = 'From: ' . $visitor_email . "\r\n" .
				   'Reply-To: ' . $visitor_email . "\r\n" .
				   'X-Mailer: PHP/' . phpversion() . "\r\n" . 
				   "MIME-Version: 1.0\r\n" . 
				   "Content-Type: text/html; charset=ISO-8859-1\r\n";

		// Sending email to admin				   
        mail($to, $subject, $message, $headers); 
		
        $success_message .= $donor_email_thank_you_message;

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
						<form action="" class="myform" method="post">
							<div class="form-row">
							
								<div class="form-group">
									<label for="">Full Name *</label>
									<input type="text" class="form-control" name="visitor_name">
								</div>
							
								<div class="form-group">
									<label for="">Phone Number</label>
									<input type="text" class="form-control" name="visitor_phone">
								</div>
							
								<div class="form-group">
									<label for="">Email Address *</label>
									<input type="text" class="form-control" name="visitor_email">
								</div>

								<div class="form-group">
									<label for="">Message *</label>
									<textarea class="form-control" name="visitor_message"></textarea>
								</div>

								<button type="submit" class="btn btn-primary" name="form1">Submit</button>
								
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-8 col-sm-8">
				<div class="donner-description">
					<div class="donner-description-list">
						<h3>Donor Details</h3>
						<table class="table table-bordered">
							<tr>
								<td style="width:200px"><span>Profession: </span></td>
								<td><?php echo $profession; ?></td>
							</tr>
							<tr>
								<td>Education: </td>
								<td><?php echo $education; ?></td>
							</tr>
							<tr>
								<td>Gender: </td>
								<td><?php echo $gender; ?></td>
							</tr>
							<tr>
								<td>Date of Birth: </td>
								<td><?php echo $date_of_birth; ?></td>
							</tr>
							<tr>
								<td>Age: </td>
								<td>
									<?php
	                                    $diff = (date('Y') - date('Y',strtotime($date_of_birth)));
	                                    echo $diff;
	                                ?>
								</td>
							</tr>
							<tr>
								<td>Religion: </td>
								<td><?php echo $religion_name; ?></td>
							</tr>
							<tr>
								<td>Email: </td>
								<td><?php echo $email; ?></td>
							</tr>
							<tr>
								<td>Phone: </td>
								<td><?php echo $phone; ?></td>
							</tr>
							<tr>
								<td>Website: </td>
								<td>
									<?php
									if($website!=''):
										echo $website;
									else:
										echo '---';
									endif;
									?>
								</td>
							</tr>
							<tr>
								<td>Address: </td>
								<td><?php echo $address; ?></td>
							</tr>
							<tr>
								<td>Country: </td>
								<td><?php echo $country; ?></td>
							</tr>
							<tr>
								<td>State: </td>
								<td>
									<?php
									if($state!=''):
										echo $state;
									else:
										echo '---';
									endif;
									?>
								</td>
							</tr>
							<tr>
								<td>City: </td>
								<td><?php echo $city; ?></td>
							</tr>
							<tr>
								<td>Zip Code: </td>
								<td><?php echo $zip_code; ?></td>
							</tr>
							<tr>
								<td>Map: </td>
								<td>
									<?php
									if($map!=''):
										echo $map;
									else:
										echo '---';
									endif;
									?>
								</td>
							</tr>
						</table>
						<h3>Description</h3>
						<p class="description">
							<?php
							if($description!=''):
								echo nl2br($description);
							else:
								echo 'No Description Found!';
							endif;
							?>
						</p>

						<h3 style="margin-top:30px;">Agent Details (Who Added This Donor)</h3>
						<table class="table table-bordered">
							<tr>
								<td style="width:200px">Agent Name: </td>
								<td><?php echo $agent_name; ?></td>
							</tr>
							<tr>
								<td>Designation: </td>
								<td><?php echo $agent_designation; ?></td>
							</tr>
							<tr>
								<td>Organization: </td>
								<td><?php echo $agent_organization; ?></td>
							</tr>
							<tr>
								<td>Email Address: </td>
								<td><?php echo $agent_email; ?></td>
							</tr>
							<tr>
								<td>Phone Number: </td>
								<td><?php echo $agent_phone; ?></td>
							</tr>
							<tr>
								<td>More about this agent: </td>
								<td>
									<a href="<?php echo BASE_URL.URL_AGENT.$agent_id; ?>">Click Here</a>
								</td>
							</tr>
						</table>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>