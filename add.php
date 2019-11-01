<?php 
session_start(); 
//session_regenerate_id(true);
//header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

if(isset($_SESSION['cart'])){

if(isset($_POST['id'])){
	$id = (int)$_POST['id'];
	$quantity = (int)$_POST['quantity'];
	$size = trim($_POST['size']);
	$length = trim($_POST['length']);

	$count = count($_SESSION['cart']);

	// Get url
	$url = $_SERVER['HTTP_REFERER'];
	$urlExplode = explode('?', $url);
	$url = $urlExplode[0];

	$newSize = strtolower($size);
	$sl = $newSize.':'.$length;

	if(!is_numeric($quantity)){
		echo json_encode(array('msg'=>'Please enter a number and not letters. Happy shopping!!'));
	}
	else{

		//Found
		$found = null;
		$name = null;
		$total = null;
		$price = null;
		$image = null;

		//get name and other details from fetched product 
		$data = json_decode(file_get_contents(url_location.'api/product/fetch_ajax.php'),true);
		foreach ($data as $data) {
			if($data['id'] == $id){
				$found = $data;
			}
		}

		$name = $found['title'];
		$image = $found['image'];
		$price = (double)$found['price'];
		$total = $quantity * $price;
		$total = (double)$total;

		//get sizes to explode
		$sizes = $found['sizes'];

		$sizeLengthArray = array();

		//explode sizes
		$explodeSize = explode(',', $sizes);

		foreach ($explodeSize as $explodeSize) {
			$explode = explode('-', $explodeSize);
			array_push($sizeLengthArray,$explode[0]);
		}

		//new size length array
		$slArray = array();

		foreach ($sizeLengthArray as $sizeLengthArray) {
			$newExplode = explode(':', $sizeLengthArray);
			$smallSize = strtolower($newExplode[0]);
			$newSl = $smallSize.':'.$newExplode[1];
			array_push($slArray, $newSl);
		}

		if(in_array($sl, $slArray)){
			function check($id, $quantity, $size){
				$count = count($_SESSION['cart']);

				for($i = 0; $i < $count; $i++){
					if($_SESSION['cart'][$i]['id'] == $id && $_SESSION['cart'][$i]['size'] == $size){
						//$_SESSION['cart'][$i]['quantity'] = $_SESSION['cart'][$i]['quantity'] + $quantity; old code
						$_SESSION['cart'][$i]['quantity'] = $quantity;
						$_SESSION['cart'][$i]['total'] = $quantity * $_SESSION['cart'][$i]['price'];
						return true;
					}else{
						continue;
					}
				}
			}

			if($count==0){
				array_push($_SESSION['cart'], array('id'=>$id, 'name'=>$name, 'quantity'=>$quantity, 'size'=>$size, 'len'=>$length, 'price'=>(double)$price, 'image'=>$image, 'total'=>(double)$total));
				$msg = 'Item Added';
				header('Location: '.$url."?id=".$id."&msg=".$msg);
			}else{
				if(check($id, $quantity,$size)){
					$msg = 'Cart Updated';
					header('Location: '.$url."?id=".$id."&msg=".$msg);
				}else{
					array_push($_SESSION['cart'], array('id'=>$id, 'name'=>$name, 'quantity'=>$quantity, 'size'=>$size, 'len'=>$length, 'price'=>(double)$price, 'image'=>$image, 'total'=>(double)$total));
					$msg = 'Item Added';
					header('Location: '.$url."?id=".$id."&msg=".$msg);
				}
			}
		}else{
			$msg = 'The selected length '.$length.' is not available for the selected size '.$size.'. Please try a different size. Happy shopping!';
			header('Location: '.$url."?id=".$id."&msg=".$msg);
		}
	}
}

}

?>