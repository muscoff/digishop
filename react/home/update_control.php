<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Control.php";

//Initialize db
$DBH = new DB();
$db = $DBH->connect();

$control = new Control($db);
$value = null;

if(isset($_GET['first'])){
	$value = $_GET['first'];
	$control->first_sec = $value;
	$control->id = $_GET['id'];

	if($control->update_one()){
		echo json_encode(array('msg'=>'updated'));
	}else{
		echo json_encode(array('msg'=>'update failed'));
	}
}
elseif(isset($_GET['second'])){
	$value = $_GET['second'];
	$control->second_sec = $value;
	$control->id = $_GET['id'];

	if($control->update_two()){
		echo json_encode(array('msg'=>'updated'));
	}else{
		echo json_encode(array('msg'=>'update failed'));
	}
}
elseif(isset($_GET['third'])){
	$value = $_GET['third'];
	$control->third_sec = $value;
	$control->id = $_GET['id'];

	if($control->update_three()){
		echo json_encode(array('msg'=>'updated'));
	}else{
		echo json_encode(array('msg'=>'update failed'));
	}
}
elseif(isset($_GET['fourth'])){
	$value = $_GET['fourth'];
	$control->fourth_sec = $value;
	$control->id = $_GET['id'];

	if($control->update_four()){
		echo json_encode(array('msg'=>'updated'));
	}else{
		echo json_encode(array('msg'=>'update failed'));
	}
}
elseif(isset($_GET['fifth'])){
	$value = $_GET['fifth'];
	$control->fifth_sec = $value;
	$control->id = $_GET['id'];

	if($control->update_five()){
		echo json_encode(array('msg'=>'updated'));
	}else{
		echo json_encode(array('msg'=>'update failed'));
	}
}
elseif(isset($_GET['sixth'])){
	$value = $_GET['sixth'];
	$control->sixth_sec = $value;
	$control->id = $_GET['id'];

	if($control->update_six()){
		echo json_encode(array('msg'=>'updated'));
	}else{
		echo json_encode(array('msg'=>'update failed'));
	}
}
elseif(isset($_GET['seventh'])){
	$value = $_GET['seventh'];
	$control->seventh_sec = $value;
	$control->id = $_GET['id'];

	if($control->update_seven()){
		echo json_encode(array('msg'=>'updated'));
	}else{
		echo json_encode(array('msg'=>'update failed'));
	}
}