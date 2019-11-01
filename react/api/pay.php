<?php   
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/libraries/lib.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/CartInfo.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Product.php";

if(isset($_POST['title'])){
	// initialize db
	$DBH = new DB();
	$db = $DBH->connect();

	// Initialize Cart Info
	$cart = new CartInfo($db);

	// Initialize Product
	$prod = new Product($db);

	require_once('../vendor/autoload.php');

	\Stripe\Stripe::setApiKey('sk_test_6hkCy8UVWyKJxcLxMjGvLTgj');

	$content = array();
	$dbContent = array();
	$error = array();
	$errorTitle = array();
	$count = count($_POST['title']);
	$string = null;
	$shipping = (int)$_POST['shipping'];
	$email = sanitize_text($_POST['email']);
	$updateQty = null;
	$cartString = '';
	for($i=0; $i<$count; $i++){
		$id= $_POST['id'][$i];
		$title= $_POST['title'][$i];
		$size= $_POST['size'][$i];
		$totalArray = array();
		$length= $_POST['length'][$i];
		$quantity= (int)$_POST['quantity'][$i];
		$image = $_POST['image'][$i];

		//Get price, and quantity from database from database
		$data = json_decode(file_get_contents(url_location.'react/api/product.php?single='.$id),true);
		$dbSize = $data['sizes'];
		$sizeCount = count($dbSize);
		for($j=0; $j<$sizeCount; $j++){
			if(strtolower($dbSize[$j]['size']) == strtolower($size) & $dbSize[$j]['len'] == $length){
				if($dbSize[$j]['quantity']<$quantity){
					$string = strtoupper($size).'-'.$length;
					array_push($error, $string);
					array_push($errorTitle, $title);
				}else{
					$updateQty = (int)$dbSize[$j]['quantity'] - $quantity;
					$dbSize[$j]['quantity'] = $updateQty;
				}
			}
		}
		
		$price = $data['price'];
		$total = (double)$quantity*$data['price'];

		$arr = array('id'=>$id, 'title'=>$title, 'sizes'=>$dbSize, 'price'=>$price, 'total'=>$total, 'image'=>$image);
		
		array_push($totalArray, $total);
		array_push($content, $arr);
		$cartString .= 'id:'.$id.',name:'.$title.',quantity:'.$quantity.',size:'.$size.',length:'.$length.',price:'.$price.',image:'.$image.'|';
	}
	$cartString = rtrim($cartString, '|');

	foreach ($content as $key => $contentvalue) {
		$updateString = '';
		foreach ($contentvalue['sizes'] as $key => $value) {
			$updateString .= $value['size'].':'.$value['len'].'-'.$value['quantity'].',';
		}
		$updateString = rtrim($updateString,',');
		$pushValue = array('id'=>$contentvalue['id'], 'sizes'=>$updateString);
		array_push($dbContent, $pushValue);
	}
	$string = return_json($dbContent);

	if(empty($error)){
		//initialize cart
		$cart->cart_items = $cartString;

		echo_json(array('msg'=>$string));
	}else{
		$msg = 'The quantities of the following item(s) [';
		$newString = ''; $lengthString = '';
		foreach ($errorTitle as $key => $eTitle) {
			$newString = $newString.$eTitle;
		}
		foreach ($error as $key => $errorValue) {
			$lengthString = $lengthString.$errorValue;
		}
		$msg = $msg.$newString.'] of the respective size and length ['.$lengthString.'] exceeded what is currently available. Please reduce their quantities and try again';
		echo_json(array('msg'=>$msg));	
	}
}