<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$data = json_decode(file_get_contents(url_location.'api/pages/page_one/fetch.php'), true);

$firstTitle = null;
$secondTitle = null;
$thirdTitle = null;

$firstLink = $data['first_link'];
$secondLink = $data['second_link'];
$thirdLink = $data['third_link'];

// get cat
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'), true);

foreach ($cat as $key => $value) {
	if($value['id'] == $firstLink){
		$firstTitle = $value['category'];
	}

	if($value['id'] == $secondLink){
		$secondTitle = $value['category'];
	}

	if($value['id'] == $thirdLink){
		$thirdTitle = $value['category'];
	}
}


echo json_encode(array('id'=>$data['id'], 'firstCap'=>$data['first_cap'], 'secondCap'=>$data['second_cap'], 'firstLink'=>$data['first_link'], 'first_title'=>$firstTitle, 'secondLink'=>$data['second_link'], 'second_title'=>$secondTitle, 'thirdLink'=>$data['third_link'], 'third_title'=>$thirdTitle, 'image'=>$data['image'], 'created'=>$data['created_at']));

