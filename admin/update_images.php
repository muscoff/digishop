<?php  
session_start();
session_regenerate_id(true);

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){
?>

<?php include "includes/head.php"; ?>

<?php include "includes/nav.php"; ?>

<?php  

$productId = isset($_GET['id'])?$_GET['id']:die();

$msg = null;
if(isset($_GET['msg'])){
	$msg =$_GET['msg'];
}

//fetch Images for this particular Image

$data = json_decode(file_get_contents(url_location.'api/product/fetch_single.php?id='.$productId),true);

$images = $data['image'];

$image = explode(',', $images);

//echo $images;

$count = count($image);

$max = 4-$count;

?>

<div class="width-100 height-10 flex-column justify-content-center align-items-center font-allerBd capitalize">
	Update images
</div>

<div class="font-allerBd blue-text center-text display-<?=((!empty($msg))?'block':'none');?>">
	<?=$msg;?>
</div>

<div>
	<div class="center-text capitalize font-allerBd grey-text"><?=$data['title'];?> images</div>
	<div class="row">
		<?php foreach($image as $key => $img): ?>
			<div class="col-3 col-s-6 padding-all-10">
				<div class="relative flex-column justify-content-center align-items-center">
					<div class="img-container-100">
						<img src="<?=$img;?>">
					</div>
					<div class="font-allerRg center-text padding-all-10">
					<a href="<?=url_location;?>api/product/delete_single_image.php?productId=<?=$productId;?>&imgName=<?=$img;?>"><span>click to delete</span></a>
					</div>
					<div class="absolute font-allerRg <?=(($key==0)?'blue':'black');?>-text">
						<a href="<?=url_location;?>api/product/product_face.php?productId=<?=$productId;?>&imgName=<?=$img;?>">
						<span class="white-bg padding-all-10 padding-s-all-2 cursor-pointer red-hover">
							<?=(($key==0)?'Product':'Use as product');?> face
						</span>
						</a>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div><hr />

<div class="margin-top-30 font-allerRg">
	<div class="center-text capitalize green-text"><span class="border-bottom-1">Upload New Images</span></div>
	
	<div class="width-40 width-s-100 margin-auto padding-all-10 display-<?=(($max==0)?'none':'block');?>">
		<form method="POST" enctype="multipart/form-data" action="<?=url_location;?>api/product/update_product_image.php">
			<input type="hidden" name="productId" value="<?=$productId;?>">
			<?php for($i = 0; $i<$max; $i++): ?>
				<div class="padding-all-20">
					<div class="font-allerRg">Image <?=$i+1;?></div>
					<input type="file" name="photo[]" class="input">
				</div>
			<?php endfor; ?>
			<div class="relative"><button name="send" class="transparent border-all-1 absolute right-10">Update Image<?=(($max==1)?'':'s');?></button></div>
		</form>
	</div>
</div>

<div class="width-100 height-10"></div>


<?php include "includes/footer.php"; ?>

<?php }else{header('Location: ../admin/');} ?>