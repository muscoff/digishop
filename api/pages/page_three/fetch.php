<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageThree.php";

//initialize db
$DBH = new DB();
$db = $DBH->connect();

//Initialize Page
$page = new PageThree($db);

//Get data
$data = $page->fetch();

echo json_encode($data);

?>