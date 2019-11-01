<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$data = json_decode(file_get_contents(url_location.'api/category/fetch.php'), true);

$compare = $data;
//get parent, child and final array
$parent = array();
// $child = array();
// $final = array();

foreach ($data as $data) {
	$parentId = null;
	if($data['parent'] == 0){
		$parentId = $data;
		$parentName = $data['category'];
		$myChild = array();
		foreach ($compare as $key => $compares) {
			if($compares['parent'] == $parentId['id']){
				$arr = array('id'=>(int)$compares['id'], 'name'=>$compares['category'], 'parentName'=>$parentName, 'parent'=>$compares['parent']);
				array_push($myChild, $arr);
			}
		}
		$arr = array('id'=>(int)$data['id'],'name'=>$parentId['category'], 'parent'=>$data['parent'],'parentName'=>'parent','children'=>$myChild);
		array_push($parent, $arr);
	}
}

echo json_encode($parent);

?>