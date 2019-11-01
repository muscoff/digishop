<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageOne.php";

$DBH = new DB();
$db = $DBH->connect();

$page = new PageOne($db);

$data = $page->fetch();

echo json_encode($data);
?>