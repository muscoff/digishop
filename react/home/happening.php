<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$data = file_get_contents(url_location.'api/pages/page_two/fetch.php');

echo $data;

?>