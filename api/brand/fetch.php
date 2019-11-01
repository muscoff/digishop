<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Brand.php";

// Database
$DBH = new DB();
$db = $DBH->connect();

// Brand
$brand = new Brand($db);

$data = $brand->fetchBrand();

echo json_encode($data);

?>