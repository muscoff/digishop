<?php  
session_start();
header('Content-type: Application/json');

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/CustomerAccount.php";

// Initialize db
$DBH = new DB();
$db = $DBH->connect();

// Initialize Customer Account
$account = new CustomerAccount($db);

$email = $_SESSION['customer_email'];

// Initialize email
$account->email = $email;

$data = $account->fetch_single();

echo json_encode($data);

?>