<?php  
//header('Content-type: Application/json');
// session_start();
// $_SESSION['cart'] = [];

//include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

// echo $_SERVER['SCRIPT_NAME'];

// echo phpinfo();

// $data = file_get_contents(url_location.'returnlocation.php');
// echo $data;

//echo file_get_contents('admin/brand.php');

// $data = file_get_contents('https://freemvt.000webhostapp.com/levis/returnip.php');
// echo $data;

// echo $_SERVER['HTTP_HOST'];
// $referer = null;

// if(isset($_SERVER['HTTP_REFERER'])){
// 	echo $_SERVER['HTTP_REFERER'];
// 	$referer = parse_url($_SERVER['HTTP_REFERER'],PHP_URL_HOST);
// }

// echo "<br />";
// echo $referer;
// echo "<br />";

// echo "<a href=''>click</a>";

// if(isset($_POST['send'])){
// 	$text = $_POST['text'];
// 	//echo 'Raw Text: '.$text;
// 	echo '<br /><br />';
// 	echo 'htmlspecialchars: '.htmlspecialchars($text);
// 	echo '<br /><br />';
// 	echo 'htmlentities: '.htmlentities($text);
// 	echo '<br /><br />';
// 	echo 'strip_tags: '.strip_tags($text);
// }

// $unique = ["Make Me","Make them","Make Us","Make Us","Make Me"];

// $make = array_unique($unique);

// foreach ($make as $key => $make) {
// 	//echo $make;
// }

//var_dump($_SERVER['WINDIR']);
//echo phpinfo();

//echo json_encode($make);

// $last = end($unique);

// echo $last;

// $dick = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;

// if(is_null($dick)){
// 	echo 'it is null';
// }

//$url = $_SERVER['HTTP_REFERER'];

include $_SERVER['DOCUMENT_ROOT']."/digishop/libraries/lib.php";

if(isset($_POST['send'])){
	if(isset($_FILES['image']) & !empty($_FILES['image']['name'][0])){
		// $count = count($_FILES['image']['name']);
		// echo $count;
		$db = 'http://localhost/digishop/images/product';
		$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/product";
		$limit = 5;
		$info = multiple_images($_FILES['image'], $limit, $db, $server);
		//$count = count($info);
		//echo $info;
		var_dump($info);
		// if($count>0){
		// 	echo json_encode($info);
		// }else{
		// 	echo json_encode($info);
		// }
	}
}

?>

<!-- <a href="<?=$url;?>">Go back to previous site</a> -->

<!-- <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body> -->

	<style type="text/css">
	*{
		box-sizing: border-box;
	}
		.xmp{
			width: 100%;
			background-image: linear-gradient(90deg, rgba(11, 10, 201, 0.6), rgba(201, 10, 201, 0.6));
			color: white;
		}
	</style>

<form method="POST" enctype="multipart/form-data">
	<input type="file" name="image[]" multiple>
	<input type="submit" name="send">
</form>

<a href="z.php">DICILY</a>
<div class="xmp">
	<xmp>
		<!-- <script type="text/javascript">
			document.querySelector('input[type="submit"]').addEventListener('click', e=>{
				console.log('button pressed');
			});
		</script> -->
		$list = array(
			array('name'=>'Jeans', 'price'=>'5.9', 'img_url'=>'http://localhost/digishop/images/men/p.png'),
			array('name'=>'Ladies Jeans', 'price'=>'7.9', 'img_url'=>'http://localhost/digishop/images/men/p1.png'),
			array('name'=>'Kids Jeans', 'price'=>'15.8', 'img_url'=>'http://localhost/digishop/images/men/p2.png'),
		);

		The above array would translate late as Json in this format

		list = [
			{"name":"Jeans", "price":"5.9", "img_url"=>"http://localhost/digishop/images/men/p.png"},
			{"name":"Ladies Jeans", "price":"7.9", "img_url"=>"http://localhost/digishop/images/men/p1.png"},
			{"name":"Kids Jeans", "price":"15.8", "img_url"=>"http://localhost/digishop/images/men/p2.png"},
		];

		foreach($list as $listItem){
			echo "<p> $listItem</p>";
		}
	}
	</xmp>
</div>

<!-- </body>
</html> -->