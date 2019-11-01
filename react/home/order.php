<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/CartInfo.php";

// Initialize db
$DBH = new DB();
$db = $DBH->connect();

// Initialize cart
$cart = new CartInfo($db);
$data = $cart->fetch();

function splitColumn($arg){
	// explode argument to get the last bit
	$explodeArg = explode(':', $arg);
	return $explodeArg[1];
}

$displayInfo = array();

foreach ($data as $key => $dataItem) {
	$UserCart = array();

	$singleInfo = $dataItem['cart_items'];

	// Explode to get individual cart info
	$explodeCart = explode('|', $singleInfo);
	foreach ($explodeCart as $explodeCart) {
		$explode = explode(',', $explodeCart);
		$putId = splitColumn($explode[0]);
		$putName = splitColumn($explode[1]);
		$putQuantity = (int)splitColumn($explode[2]);
		$putSize = splitColumn($explode[3]);
		$putLength = splitColumn($explode[4]);
		$putPrice = (float)splitColumn($explode[5]);
		$putImage = ltrim($explode[6], 'image:');

		$arrayPush = array('id'=>$putId, 'name'=>$putName, 'quantity'=>$putQuantity, 'size'=>$putSize, 'length'=>$putLength, 'price'=>$putPrice, 'image'=>$putImage);
		array_push($UserCart, $arrayPush);
	}

	$arr = array('id'=>(int)$dataItem['id'], 'customer_id'=>$dataItem['customer_id'], 'email'=>$dataItem['email'], 'cart'=>$UserCart, 'created_at'=>$dataItem['created_at']);

	array_push($displayInfo, $arr);

}

echo json_encode($displayInfo);

?>