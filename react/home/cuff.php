<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$data = json_decode(file_get_contents(url_location.'api/pages/page_seven/fetch.php'), true);
$title = null;
$link = $data['page_link'];

// get cat
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'), true);

foreach ($cat as $key => $cat) {
	if($cat['id'] == $link){
		$title = $cat['category'];
	}
}

$arr = array('id'=>$data['id'], 'link'=>$link, 'title'=>$title, 'image'=>$data['image'], 'first_cap'=>$data['first_cap'], 'second_cap'=>$data['second_cap'], 'third_cap'=>$data['third_cap'], 'created_at'=>$data['created_at']);


echo json_encode($arr);

?>