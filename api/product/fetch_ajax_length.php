<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
$data = json_decode(file_get_contents(url_location.'api/product/fetch_ajax.php'),true);

//Get size
$length = isset($_GET['length'])?$_GET['length']:die();
$length = trim($length);

$product = array();

foreach ($data as $data) {
	$id = $data['id'];
	$title = $data['title'];
	$price = $data['price'];

	$image = $data['image'];
	$dbLength = explode(',', $data['sizes']);
	foreach ($dbLength as $dbLength) {
		$explodeDbLength = explode('-', $dbLength);
		//size and length
		$sl = $explodeDbLength[0];
		$explodeSl = explode(':', $sl);
		$fetchLength = $explodeSl[1];

		if($length == $fetchLength & $data['featured'] == 1){
			$prouctArray = array('id'=>$id, 'title'=>$title, 'image'=>$image, 'price'=>$price);
			array_push($product, $prouctArray);
		}
	}
}

echo json_encode($product);


?>