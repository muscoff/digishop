<?php  
session_start();
session_regenerate_id(true);

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){
?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/head.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/nav.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/section_nav.php"; ?>

<?php  

//Get Page Data
$data = json_decode(file_get_contents(url_location.'api/pages/page_five/fetch.php'),true);
$count = count($data);
$first_cap = $data['first_cap'];
$second_cap = $data['second_cap'];
$third_cap = $data['third_cap'];

//Get category
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);
//Parent Array
$parent = array();

foreach ($cat as $cat) {
	if($cat['parent'] == 0){
		$arr = array('id'=>$cat['id'], 'category'=>$cat['category'], 'parent'=>$cat['parent']);
		array_push($parent, $arr);
	}
}

$first = $parent; //First Link List
$second = $parent; //Second Link List

$msg = isset($_GET['msg'])?$_GET['msg']:null;

?>


<div class="font-allerBd uppercase center-text margin-top-10">fifth section</div>
<div class="display-<?=((!empty($msg))?'block':'none');?>">
	<div class="width-100 height-10 flex-column justify-content-center align-items-center font-allerRg blue-text">
		<?=$msg;?>
	</div>
</div>

<div class="margin-top-20">
	<div class="container">
		<div class="row">
			<div class="col-6 col-s-12 padding-all-10 relative">
				<form method="POST" enctype="multipart/form-data" action="<?=url_location;?>api/pages/page_five/<?=(($count>0)?'edit':'create');?>.php">
					<div class="margin-top-10">
						<div class="uppercase font-allerRg">image 1</div>
						<input type="file" class="input" name="image" /><br />
					</div>

					<?php if($count>0): ?>
						<div><input type="hidden" name="id" value="<?=$data['id'];?>"></div>
					<?php endif; ?>

					<div class="margin-top-10">
						<div class="uppercase font-allerRg">First caption</div>
						<input type="text" name="first_cap" value="<?=((!empty($first_cap))?$first_cap:'');?>" /><br />
					</div>

					<div class="margin-top-10">
						<div class="uppercase font-allerRg">second caption</div>
						<input type="text" name="second_cap" value="<?=((!empty($second_cap))?$second_cap:'');?>" /><br />
					</div>

					<div class="margin-top-10">
						<div class="uppercase font-allerRg">third caption</div>
						<input type="text" name="third_cap" value="<?=((!empty($third_cap))?$third_cap:'');?>" /><br />
					</div>

					<div class="row">
						<div class="col-6 col-s-12 padding-all-10">
							<div class="font-allerRg">Link 1</div>
							<select name="first">
								<?php foreach($first as $first): ?>
									<option value="<?=$first['id'];?>" <?=(($count>0 & $first['id'] == $data['first_link'])?'selected':'');?> ><?=$first['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col-6 col-s-12 padding-all-10">
							<div class="font-allerRg">Link 2</div>
							<select name="second">
								<?php foreach($second as $second): ?>
									<option value="<?=$second['id'];?>" <?=(($count>0 & $second['id'] == $data['second_link'])?'selected':'');?>><?=$second['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div><button type="submit"><?=(($count>0)?'edit':'Submit');?></button></div>
				</form>
				<?php if($count>0): ?>
					<div class="absolute bottom-0 right-0">
						<a href="<?=url_location;?>api/pages/page_five/delete.php?id=<?=$data['id'];?>">
							<button class="transparent border-all-1">Delete</button>
						</a>
					</div>
				<?php endif; ?>
			</div>
			<div class="col-6 col-s-12 padding-all-10">
				<div class="center-text font-allerBd uppercase">section map</div>
			</div>
		</div>
	</div>
</div>

<div class="width-100 height-100 height-s-50 overflow-hidden margin-top-20">
	<div class="center-text font-allerBd">Preview</div>
	<div class="width-100 height-100 margin-top-20">
		<div class="full iframe">
			<iframe src="/digishop/pages/sectionfive.php"></iframe>
		</div>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/footer.php"; ?>

<?php }else{header('Location: ../admin/');} ?>