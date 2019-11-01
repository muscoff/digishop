<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageSix.php";

//Initialize db
$DBH = new DB();
$db = $DBH->connect();

//Initialize page model
$page = new PageSix($db);

//Get data
$data = $page->fetch();

echo json_encode($data);

?>