<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageFive.php";

//Initialize db
$DBH = new DB();
$db = $DBH->connect();

// Initialize Page
$page = new PageFive($db);

// Get Data
$data = $page->fetch();

echo json_encode($data);

?>