<?php
ob_start();
session_start();
require_once('../../admin/config.php');

$error_message = '';

if(isset($_POST['form1'])) {
	$valid = 1;
	if(empty($_POST['pricing_plan_id'])) {
		$valid = 0;
		$error_message .= 'You must have to select a pricing plan<br>';
	}
	if(empty($_POST['payment_date'])) {
		$valid = 0;
		$error_message .= 'You must have to select a payment date<br>';
	}
	if($valid == 0) {
		header('location: '.BASE_URL.'payment.php?msg='.$error_message);
		exit;
	}
}


$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$paypal_email = $row['paypal_email'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_pricing_plan WHERE pricing_plan_id=?");
$statement->execute(array($_POST['pricing_plan_id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$item_name = $row['pricing_plan_name'];
	$item_amount = $row['pricing_plan_price'];
	$valid_day = $row['pricing_plan_day'];
}

$return_url = BASE_URL . 'payment/paypal/payment_process.php';
$cancel_url = BASE_URL . 'payment.php';
$notify_url = BASE_URL . 'payment/paypal/verify_process.php';

//$item_name = 'Car';
$item_number = time();

$payment_date = $_POST['payment_date'];
$ts = strtotime($payment_date);
$expire_date = date('Y-m-d',strtotime('+'.$valid_day.' days',$ts));




// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
	$querystring = '';
	
	// Firstly Append paypal account to querystring
	$querystring .= "?business=".urlencode($paypal_email)."&";
	
	// Append amount& currency (£) to quersytring so it cannot be edited in html
	
	//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
	$querystring .= "item_name=".urlencode($item_name)."&";
	$querystring .= "amount=".urlencode($item_amount)."&";
	$querystring .= "item_number=".urlencode($item_number)."&";
	
	//loop for posted values and append to querystring
	foreach($_POST as $key => $value){
		$value = urlencode(stripslashes($value));
		$querystring .= "$key=$value&";
	}
	
	// Append paypal return addresses
	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
	$querystring .= "notify_url=".urlencode($notify_url);
	
	// Append querystring with custom field
	//$querystring .= "&custom=".USERID;

	$statement = $pdo->prepare("INSERT INTO tbl_payment (
						agent_id,
						payment_date,
						expire_date,
						txnid, 
						paid_amount,
						pricing_plan_id,
						payment_status, 
						payment_id
						) 

						VALUES (?,?,?,?,?,?,?,?)");
	$sql = $statement->execute(array(
						$_POST['agent_id'],
						$payment_date,
						$expire_date,
						'',
						$item_amount,
						$_POST['pricing_plan_id'],
						'Pending',
						$item_number
					));

	
	if($sql){
		// Redirect to paypal IPN
		header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
		exit();
	}
	
} else {

	// Response from Paypal

	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
		$req .= "&$key=$value";
	}
	
	// assign posted variables to local variables
	$data['item_name']			= $_POST['item_name'];
	$data['item_number'] 		= $_POST['item_number'];
	$data['payment_status'] 	= $_POST['payment_status'];
	$data['payment_amount'] 	= $_POST['mc_gross'];
	$data['payment_currency']	= $_POST['mc_currency'];
	$data['txn_id']			    = $_POST['txn_id'];
	$data['receiver_email'] 	= $_POST['receiver_email'];
	$data['payer_email'] 		= $_POST['payer_email'];
	$data['custom'] 			= $_POST['custom'];
		
	// post back to PayPal system to validate
	$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	
	$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
	
	if (!$fp) {
		// HTTP ERROR
		
	} else {
		fputs($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			if (strcmp($res, "VERIFIED") == 0) {
				
				// Used for debugging
				// mail('user@domain.com', 'PAYPAL POST - VERIFIED RESPONSE', print_r($post, true));
				
			
			} else if (strcmp ($res, "INVALID") == 0) {
			

				// PAYMENT INVALID & INVESTIGATE MANUALY!
				// E-mail admin or alert user
				
				// Used for debugging
				//@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
			}
		}
	fclose ($fp);
	}
}