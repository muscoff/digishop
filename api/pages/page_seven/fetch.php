<?php  
header("Content-type: Application/json");
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageSeven.php";

//Initialize db
$DBH = new DB();
$db = $DBH->connect();

//Initialize page
$page = new PageSeven($db);

$data = $page->fetch();

echo json_encode($data);

?>