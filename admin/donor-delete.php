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

	// Getting donor featured photo and unlink
	$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE donor_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		unlink('../assets/uploads/donors/'.$row['photo']);
	}
	
	// Delete from tbl_donor
	$statement = $pdo->prepare("DELETE FROM tbl_donor WHERE donor_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: donor-approved.php');
?>