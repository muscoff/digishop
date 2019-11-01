<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Product.php";

// Database
$DBH = new DB();
$db = $DBH->connect();

// Product
$product = new Product($db);

//Get Url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

// Get admin id
$product->featured = isset($_GET['featured'])? $_GET['featured']: die();
$product->id = isset($_GET['productId'])? $_GET['productId']: die();

if($product->updateFeatured()){
	header('Location: '.$url);
}else{
	header('Location: '.$url.'?msg=Failed to unfeatured');
}

?>