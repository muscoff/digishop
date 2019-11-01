<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$id = isset($_GET['id'])?$_GET['id']:die();
$email = isset($_GET['email'])?$_GET['email']:die();

$data = json_decode(file_get_contents(url_location.'react/home/order.php'), true);

$sendBack = null;

if(!empty($id) & !empty($email)){

foreach ($data as $key => $value) {
	if($value['id'] == $id && $value['email'] == $email){
		$sendBack = $value;
	}
}

echo json_encode($sendBack);
}

?>