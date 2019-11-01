<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Category.php";

// Database
$DBH = new DB();
$db = $DBH->connect();

// Category
$category = new Category($db);

$data = $category->getParent();

echo json_encode($data);

?>