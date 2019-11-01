<?php  
header('Content-type: Application/json');
session_start();
//session_regenerate_id(true);

if(isset($_SESSION['cart'])){
	if(isset($_GET['total'])){
	$quantity = array();

	foreach ($_SESSION['cart'] as $value) {
		array_push($quantity, $value['quantity']);
	}

	$sum = array_sum($quantity);

	echo json_encode(array('total'=>$sum));
	}elseif(isset($_GET['price'])){
		$priceArray = array();

		foreach ($_SESSION['cart'] as $price) {
			array_push($priceArray, $price['total']);
		}
		$sum = array_sum($priceArray);
		echo json_encode(array('price'=>$sum));
	}else{
		echo json_encode($_SESSION['cart']);
	}
}


?>