<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Product.php";

// Database
$DBH = new DB();
$db = $DBH->connect();

// Product
$product = new Product($db);

// Get admin id and product Id
$product->id = isset($_GET['id'])? $_GET['id']: die();
$data = $product->fetch_single();

echo json_encode($data);

?>