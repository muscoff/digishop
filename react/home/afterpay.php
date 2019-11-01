<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$data = json_decode(file_get_contents(url_location.'api/pages/page_three/fetch.php'), true);

$first_title = null;
$second_title = null;

$firstLink = $data['first_link'];
$secondLink = $data['second_link'];

// get cat
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'), true);
foreach ($cat as $key => $cat) {
	if($cat['id'] == $firstLink){
		$first_title = $cat['category'];
	}

	if($cat['id'] == $secondLink){
		$second_title = $cat['category'];
	}
}

$arr = array('id'=>$data['id'], 'first_cap'=>$data['first_cap'], 'second_cap'=>$data['second_cap'], 'first_title'=>$first_title, 'second_title'=>$second_title, 'first_link'=>$firstLink, 'second_link'=>$secondLink, 'created_at'=>$data['created_at']);

echo json_encode($arr);

?>