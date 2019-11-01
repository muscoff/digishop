<?php  
//header('Content-type: Application/json');
session_start();
session_regenerate_id(true);

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/CartInfo.php";

// initialize db
// $DBH = new DB();
// $db = $DBH->connect();

// // Initialize Cart Info
// $cart = new CartInfo($db);

// $data = $cart->fetch();

//echo json_encode($data);


?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/head.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/nav.php"; ?>
<div class="width-100 height-50 flex-column justify-content-center align-items-center font-allerRg">
	<div class="deep-grey-text center-text">Thank you for choosing us!</div>
	<div class="margin-top-10 center-text">Please check your email for the expected date you'd receive your items</div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/footer.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/script.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/tail.php"; ?>