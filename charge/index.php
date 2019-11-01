<?php 
session_start();
session_regenerate_id(true);

include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/CartInfo.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Product.php";

if(!empty($_SESSION['cart'])){
// initialize db
$DBH = new DB();
$db = $DBH->connect();

// Initialize Cart Info
$cart = new CartInfo($db);

// Initialize Product
$prod = new Product($db);

$count = count($_SESSION['cart']);

require_once('../vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_6hkCy8UVWyKJxcLxMjGvLTgj');



$string = '';

foreach ($_SESSION['cart'] as $value) {
	$string .= 'id:'.$value['id'].','.'name:'.$value['name'].','.'quantity:'.$value['quantity'].','.'size:'.$value['size'].','.'length:'.$value['len'].','.'price:'.$value['price'].','.'image:'.$value['image'].'|';
}

$string = rtrim($string,'|');


$errorNames = array();
$errorAvailable = array();

$newArrName = array();
$newArrSize = array();

$first = array();
$firstString = '';
$firstFinal = array();

$finalQty = null;

foreach ($_SESSION['cart'] as $cartItem) {
	$itemId = $cartItem['id'];
	$size = $cartItem['size'].':'.$cartItem['len'];
	$size = strtolower($size);

	$userQty = $cartItem['quantity'];
	//echo $size.'<br /><br />';

	$prod->id = $itemId;

	$prodJson = $prod->fetch_single();

	$dbSize = strtolower($prodJson['sizes']);

	$explodeSize = explode(',', $dbSize);

	foreach ($explodeSize as $explodeSize) {
		$dbS = explode('-', $explodeSize);
		$databaseSize = strtolower($dbS[0]);
		$dbQty = $dbS[1];

		if($databaseSize == $size){
			//echo 'found <br />';
			if($userQty > $dbQty){
				array_push($newArrName, $prodJson['title']);
				array_push($newArrSize, $dbQty);
			}else{
				$finalQty = $dbQty - $userQty;
				$newString = $databaseSize.'-'.$finalQty;
				array_push($first, $newString);
			}
		}else{
			$newString = $databaseSize.'-'.$dbS[1];
			array_push($first, $newString);
		}
	}

	foreach ($first as $firstValue) {
		$firstString .= $firstValue.','; 
	}
	$firstString = rtrim($firstString, ',');
	array_push($firstFinal, $firstString);
	$first = [];
	$firstString = '';
}

$makeUniqueName = array_unique($newArrName);
$makeUniqueSize = array_unique($newArrSize);
foreach ($makeUniqueName as $key => $make) {
	array_push($errorNames, $make);
}

foreach ($makeUniqueSize as $key => $makeSize) {
	array_push($errorAvailable, $makeSize);
}

$errorString = '';
$errorDbQty = '';
if(!empty($errorNames)){ //check for errors and output
	foreach ($errorNames as $key => $errorNames) {
		$errorString .= $errorNames.',';
	}

	foreach ($errorAvailable as $key => $errorAvailable) {
		$errorDbQty .= $errorAvailable.',';
	}

	echo 'The Quantity(s) for '.$errorString.' unfortunately exceed what we currently have. Our available quantity(s) is '.$errorDbQty.' respectively. Please Edit your order quantity and proceed with payment!';
}else{

	$token = null;
	if(isset($_POST['stripeToken'])){
	    $token = $_POST['stripeToken'];
	}

	$confirm = false;

	$email = $_SESSION['details']['email'];
	$amount = $_SESSION['final']*100; //Times 100 because 1USD = 100 or 1GBP = 100

	$description = 'Payment of '.$count.' items bought @digishop for a sum total of '.$_SESSION['final'].' This amount also includes shipping fees.';

	$customer = \Stripe\Customer::create(array(
	    "email" => $email,
	    "source" => $token
	));

	$charge = \Stripe\Charge::create(array(
	    "amount" => $amount,
	    "currency" => "gbp",
	    "description" => $description,
	    "customer" => $customer->id
	));

	$checker = array();

	foreach ($_SESSION['cart'] as $key => $cartValues) {
		$updateId = $cartValues['id'];
		$prod->id = $updateId;
		$prod->sizes = $firstFinal[$key];

		if($prod->updateSizeFromCart()){
			array_push($checker, true);
		}else{
			array_push($checker, false);
		}
	}

	if(!in_array(false, $checker)){
		$cart->customer_id = $customer->id;
		$cart->email = $_SESSION['details']['email'];
		$cart->cart_items = $string;

		if($cart->create()){
			header('Location: '.url_location.'success/');
		}else{
			die('...Failed...');
		}
	}else{
		die('...');
	}
}

}
else{
	die('....Don\'t be an ass....');
}

?>