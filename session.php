<?php  
session_start();
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$randId = rand(1,10000000);
$_SESSION['id'] = $randId;
$_SESSION['cart'] = array();
$_SESSION['details'] = array();
$_SESSION['country'] = 'GHANA';
$_SESSION['shipping'] = 10;
$_SESSION['sign_up_token'] = md5(uniqid(rand()));
$_SESSION['sign_in_token'] = md5(uniqid(rand()));
$_SESSION['account_token'] = md5(uniqid(rand()));
$_SESSION['checkout_login_token'] = md5(uniqid(rand()));
$_SESSION['paid'] = false;

//get location from where the site is visited from
//$location = json_decode(file_get_contents(url_location.'location/'),true);

//echo $randId;

header('location: index.php');
//echo '<br /> <a href="destroy.php">Go to destroy session</a>';

//echo '<br /> <a href="index.php">View ID on home page</a>';


?>