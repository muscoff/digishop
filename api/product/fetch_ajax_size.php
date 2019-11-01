<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
$data = json_decode(file_get_contents(url_location.'api/product/fetch_ajax.php'),true);

//Get size
$size = isset($_GET['size'])?$_GET['size']:die();
$size = trim($size);
$size = strtolower($size);

$product = array();

foreach ($data as $data) {
	$id = $data['id'];
	$title = $data['title'];
	$price = $data['price'];

	$image = $data['image'];
	$dbSize = explode(',', $data['sizes']);
	foreach ($dbSize as $dbSize) {
		$explodeDbSize = explode('-', $dbSize);
		//size and length
		$sl = $explodeDbSize[0];
		$explodeSl = explode(':', $sl);
		$fetchSize = $explodeSl[0];
		$fetchSize = strtolower($fetchSize);

		if($size == $fetchSize & $data['featured'] == 1){
			$prouctArray = array('id'=>$id, 'title'=>$title, 'image'=>$image, 'price'=>$price);
			array_push($product, $prouctArray);
		}
	}
}

echo json_encode($product);


?>