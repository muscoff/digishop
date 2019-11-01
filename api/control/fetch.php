<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Control.php";

//Initialize db
$DBH = new DB();
$db = $DBH->connect();


//Initialize Control
$control = new Control($db);
$data = $control->fetch();

echo json_encode($data);
?>