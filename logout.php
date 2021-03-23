<?php 
ob_start();
session_start();
include 'admin/config.php';
unset($_SESSION['agent']);
header("location: ".BASE_URL); 
?>