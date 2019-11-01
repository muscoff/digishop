<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/CustomerAccount.php";

// get email
$email = isset($_GET['email'])?$_GET['email']:die();

// initialize db
$DBH = new DB();
$db = $DBH->connect();

// initialize customer account
$customer = new CustomerAccount($db);

$data = $customer->fetch();

$info = null;

if(!empty($email)){
	foreach ($data as $key => $value) {
		if($value->email == $email){
			$info = $value;
		}
	}

	echo json_encode($info);
}

?>