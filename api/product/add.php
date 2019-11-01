<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Product.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

// Database
$DBH = new DB();
$db = $DBH->connect();

// Product
$product = new Product($db);

$url = $_SERVER['HTTP_REFERER'];

$explode = explode('?', $url);

$url = $explode[0];

// Get admin id and other details
if(isset($_POST['title']) & !empty($_POST['title'])){
	$title = $_POST['title'];
	$price = $_POST['price'];
	$brand = $_POST['brand'];
	$parent = $_POST['parent_cat'];
	$child = $_POST['child_cat'];
	$description = $_POST['description'];
	$sizes = $_POST['size'];
	$sizes = rtrim($sizes, ',');

	$checkPost = [$title, $price, $brand, $parent, $child, $description, $sizes];

	// Check if any of the post data is empty
	if(in_array('', $checkPost)){
		//die('POST data cannot be empty');
		header('Location: '.$url.'?add=1&msg=POST data cannot be empty');
	}else{

	//Initialize data for database with the exception of image
	$product->title = $title;
	$product->price = $price;
	$product->brand = $brand;
	$product->parent_cat = $parent;
	$product->child_cat = $child;
	$product->description = $description;
	$product->sizes = $sizes;

	//check if post data title in already in database
	$checkData = json_decode(file_get_contents(url_location.'api/product/fetch.php'),true);
	$checkDataArray = array();
	//echo json_encode($checkData); //Comment this from the file uploaded to the server

	//check if server data is not empty to begin with
	
	foreach ($checkData as $checkData) {
		if(strtolower($checkData['title'])==strtolower($title) && $checkData['brand'] == $brand && $checkData['parent_cat'] == $parent){
			array_push($checkDataArray, $checkData['title']);
		}
	}

	if(count($checkDataArray)>0){
		header('Location: '.$url."?msg=Product already exist");
	}
	else{

	// Check if image is not empty to upload
	if(isset($_FILES) & !empty($_FILES['photo']['name'][0])){
		$count = count($_FILES['photo']['name']);

		if($count>4){
			die(json_encode(array('msg'=>'You cannot upload more than 4 pictures of one item')));
		}else{
			$img_name = array();
			$img_move = array();
			$img_temp = array();
			$truth = array();
			$db_img = '';
			$max_size = 2097152; //Standard Size = Max size
			$typeStack = ['image/png', 'image/jpeg', 'image/jpg'];

			for($i = 0; $i<$count; $i++){
				$imgName = $_FILES['photo']['name'][$i];
				$imgSize = $_FILES['photo']['size'][$i];
				$imgType = $_FILES['photo']['type'][$i];
				$imgTmp = $_FILES['photo']['tmp_name'][$i];
				$imgError =$_FILES['photo']['error'][$i];
				if($imgSize<= $max_size && in_array($imgType, $typeStack) && $imgError != 1){
					$explode_img = explode('.', $imgName);
					$photo = $explode_img[0];
					$ext = $explode_img[1];
					$rand = rand(1,1000000); //Generate random number
					$photo = md5($rand.$photo);
					$imgName = img_folder.$photo.'.'.$ext; 
					$move = $_SERVER['DOCUMENT_ROOT']."/digishop/images/product/".$photo.'.'.$ext;
					// I have defined img_folder which can be found in definitions Folder
					array_push($img_name, $imgName); // name for database
					array_push($img_move, $move);
					array_push($img_temp, $imgTmp);	//temp location on server
				}else{
					die('Please make sure to upload an image or images of size not more than 2MB');
				}
				// Enf of If
			} 
			// End of For Loop
			foreach ($img_name as $img) {
				$db_img = $db_img.$img.',';  
			}

			$db_img = rtrim($db_img, ',');

			$folder = $_SERVER['DOCUMENT_ROOT'].'/digishop/images/product/';
			if(file_exists($folder)){
				$len = count($img_name); //length of pictures to be uploaded
				for($j=0; $j<$len; $j++){
					if(move_uploaded_file($img_temp[$j], $img_move[$j])){
						array_push($truth, true);
					}else{
						array_push($truth, false);
					}
				}

				//Check if false exist in truth array before you insert in database
				//The truth array signals if all the images have been moved to the server successfully
				if(in_array(false, $truth)){
					//If false, remove the images that were uploaded to the server
					foreach ($img_move as $move) {
						unlink($move);
					}
				}else{
						//POST data image for database and execute
						$product->image = $db_img; //image for database
						$msg = $product->add();

						//if data was successfully inserted into the database, the msg array returns success
						//else failed
						if($msg['msg'] == 'success'){
							header('Location: '.$url."?add=1&msg=".$title." has been added successfully");
						}else{
							foreach ($img_move as $moved) {
								unlink($moved);
							}
							header('Location: '.$url."?add=1&msg=Failed to add ".$title);
						}
				}
				//echo json_encode(array('msg'=>img_folder));
			}else{
				$path = $_SERVER['DOCUMENT_ROOT'].'/digishop/';
				//Check if the folder images exist, if it doesn't, create the folder images
				((file_exists($path.'images/'))?'':mkdir($path.'images/'));
				//Check if the folder images/product exist, if it doesn't, create the folder product inside images
				((file_exists($path.'images/product/'))?'':mkdir($path.'images/product/'));

				$len = count($img_name); //length of pictures to be uploaded
				
				for($j=0; $j<$len; $j++){
					if(move_uploaded_file($img_temp[$j], $img_move[$j])){
						array_push($truth, true);
					}else{
						array_push($truth, false);
					}
				}

				//Check if false exist in truth array before you insert in database
				//The truth array signals if all the images have been moved to the server successfully
				if(in_array(false, $truth)){
					//If false, remove the images that were uploaded to the server
					foreach ($img_move as $move) {
						unlink($move);
					}
					header('Location: '.$url."?add=1&msg=Images were not uploaded. Check file type or consult admin");
				}else{
						//POST data image for database and execute
						$product->image = $db_img; //image for database
						$msg = $product->add();

						//if data was successfully inserted into the database, the msg array returns success
						//else failed
						if($msg['msg'] == 'success'){
							header('Location: '.$url."?add=1&msg=".$title." added successfully");
						}else{
							foreach ($img_move as $moved) {
								unlink($moved);
							}
							header('Location: '.$url."?add=1&msg=Failed to add ".$title);
						}
				}
			}
			//echo json_encode(array('db_img'=>$db_img));
		}
		// End of count validation
	}else{
		header('Location: '.$url.'?add=1&msg=At least one product image must be uploaded');
	}
	// End of $_FILES
	}//End of if-else for when it exist in database
	}//End of if for when an empty string exist in the post data array
}

?>