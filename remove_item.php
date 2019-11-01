<?php  
session_start();
//session_regenerate_id(true);

if(isset($_SESSION['cart'])){
	$cart = $_SESSION['cart'];
	$holder = array();
	if(isset($_GET['key'])){
		$removekey = $_GET['key'];

		foreach ($cart as $key => $cart) {
			if($key != $removekey){
				array_push($holder, $cart);
			}
		}

		$_SESSION['cart'] = $holder;

		echo json_encode(array('msg'=>true));
	}
}

?>