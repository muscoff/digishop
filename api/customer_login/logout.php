<?php  
session_start();
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

session_unset();

session_destroy();

header('Location: '.url_location);

?>