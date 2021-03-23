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

	// Getting car featured photo and unlink
	$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE donor_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		unlink('assets/uploads/donors/'.$row['photo']);
	}

	// Delete from tbl_donor
	$statement = $pdo->prepare("DELETE FROM tbl_donor WHERE donor_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: '.BASE_URL.DONOR_VIEW);
?>