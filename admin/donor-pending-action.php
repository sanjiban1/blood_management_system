<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE donor_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
	
	$statement = $pdo->prepare("UPDATE tbl_donor SET status=? WHERE donor_id=?");
	$statement->execute(array(1,$_REQUEST['id']));


	// Send email to agent that his item is approved
	
	// getting agent id from tbl_donor
	$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE donor_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$agent_id = $row['agent_id'];
	}

	// getting agent email address from tbl_agent
	$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=?");
	$statement->execute(array($agent_id));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$agent_email = $row['agent_email'];
	}

	$donor_page_url = BASE_URL.'donor.php?id='.$_REQUEST['id'];

	$subject = 'Your donor update is approved and is live now.';
	$message = 'Your update for the selected donor information is approved successfully! Please visit the following link to see it live: <br><a href="'.$donor_page_url.'">'.$donor_page_url.'</a>';

	$headers = 'From: ' . $visitor_email . "\r\n" .
			   'Reply-To: ' . $visitor_email . "\r\n" .
			   'X-Mailer: PHP/' . phpversion() . "\r\n" . 
			   "MIME-Version: 1.0\r\n" . 
			   "Content-Type: text/html; charset=ISO-8859-1\r\n";

	// Sending email to admin				   
    mail($agent_email, $subject, $message, $headers);

	header('location: donor-pending.php');
?>