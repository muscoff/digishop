<?php 
session_start(); 

// $arr = [array('id'=>1, 'name'=>'joe'), array('id'=>2, 'name'=>'john'), array('id'=>3, 'name'=>'jay')];

// foreach ($arr as $arr) {
// 	if($arr['id']!=1){
// 		echo json_encode($arr).'<br />';
// 	}
// }
//echo json_encode($arr);

include $_SERVER['DOCUMENT_ROOT']."/digishop/libraries/lib.php";
$referer = from_another_url();
// if(empty($_SESSION['url'])){
// 	$_SESSION['url'] = $referer;
// }
if(check_host($referer)){
	echo 'good job';
}else{
	echo 'hell na!';
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		*{
			list-style: none;
			text-decoration: none;
		}
		ul{
			/*position: fixed;*/
	margin: 0px;
	padding: 0px;
}

ul li{
	max-width: 200px;
	height: 30px;
	float: left;
	padding-right: 20px;
	line-height: 30px;
	/*color: white;*/
	text-align: left;
	/*background-color: #03036B;*/
}

ul li a{
	display: block;
	/*color: white;*/
}

ul li a:hover{
	background-color: rgba(0,0,0,.5);
}

ul li ul li{
	display: none;
}

ul li:hover ul li{
	display: block;
	max-width: 200px;
	max-height: 40px;
	background: black;
	/*padding-left: 5px;*/
}

.toast{
	max-width: 25%;
	color: white;
	text-align: center;
	padding: 10px;
}

.black-bg{
	background-color: black;
}

.fixed{
	position: fixed;
}

.bottom-0{
	bottom: 20%;
}

	</style>
</head>
<body>
	<div><?=$_SESSION['url']; ?></div>
<div class="nav">
	<ul>
		<li><a href="">Men</a>
			<ul>
				<li><a href="">jeans</a></li>
			</ul>
		</li>
		<li><a href="">Women</a>
			<ul>
				<li><a href="">skirt</a></li>
			</ul>
		</li>
		<li><a href="">Boys</a></li>
	</ul>
</div>
<script type="text/javascript">
	function toast(obj){
		let toast = document.createElement('div');
		toast.className = 'fixed bottom-0 toast black-bg';
		toast.innerHTML = obj.msg;
		document.body.appendChild(toast);
	}

	toast({msg: 'dickknkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkn'});

	//toast({"msg": 'hey'});
</script>
</body>
</html>