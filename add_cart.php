<?php  
session_start();
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

if(isset($_SESSION['cart'])){

	if(isset($_POST['id'])){
		$count = count($_SESSION['cart']);
		$id = $_POST['id'];
		$size = trim($_POST['size']);
		$size = strtolower($size);
		$length = trim($_POST['length']);
		$quantity = $_POST['quantity'];
		$quantity = (int)$quantity;

		$validate = false;

		$single = json_decode(file_get_contents(url_location.'api/product/fetch_single.php?id='.$id),true);
		$name = $single['title'];
		$image = $single['image'];
		$price = $single['price'];
		$price = (double)$price;
		$total = $price * $quantity;
		$total = (double)$total;
		$singleSize = $single['sizes'];
		$sizeArray = array();

		$explode = explode(',', $singleSize);
		foreach ($explode as $key => $value) {
			$newExplode = explode('-', $value);

			// explode to get size and length
			$newLength = explode(':', $newExplode[0]);
			$s = $newLength[0];
			$l = $newLength[1];

			if(strtolower($s) == $size & $l == $length){
				$validate = true;
			}
			$arr = array('size'=>$s, 'length'=>$l);
			array_push($sizeArray, $arr);
		}

		function check($id, $size, $quantity){
			$count = count($_SESSION['cart']);
			for($i=0; $i<$count; $i++){
				if($_SESSION['cart'][$i]['id'] == $id & $_SESSION['cart'][$i]['size'] == $size){
					$_SESSION['cart'][$i]['quantity'] = $quantity;
					$_SESSION['cart'][$i]['total'] = $quantity * $_SESSION['cart'][$i]['price'];
					return true;
				}else{
					continue;
				}
			}
		}

		if($validate){
			if($count == 0){
				array_push($_SESSION['cart'], array('id'=>$id, 'name'=>$name, 'quantity'=>$quantity, 'size'=>$size, 'len'=>$length, 'price'=>(double)$price, 'image'=>$image, 'total'=>(double)$total));
				$msg = 'Item Added';
				echo json_encode(array('msg'=>$msg));
			}
			else{
				if($check($id, $size, $quantity)){
					$msg = 'Cart Updated';
					echo json_encode(array('msg'=>$msg));
				}else{
					array_push($_SESSION['cart'], array('id'=>$id, 'name'=>$name, 'quantity'=>$quantity, 'size'=>$size, 'len'=>$length, 'price'=>(double)$price, 'image'=>$image, 'total'=>(double)$total));
					$msg = 'Item Added';
					echo json_encode(array('msg'=>$msg));
				}
			}
		}else{
			$msg = 'The selected length "'.$length.'" is not available for the the selected size "'.$size.'". Please choose a different size';
			echo json_encode(array('msg'=>$msg));
		}
	}

}