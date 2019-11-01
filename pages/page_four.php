<?php  
session_start();
session_regenerate_id(true);

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){
?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/head.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/nav.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/section_nav.php"; ?>

<?php  
//get msg
$msg = isset($_GET['msg'])?$_GET['msg']:null;

//Get Page Data
$data = json_decode(file_get_contents(url_location.'api/pages/page_four/fetch.php'),true);
$count = count($data);
//echo $count;

// Get category
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);
$parent = array();

foreach ($cat as $cat) {
	if($cat['parent']==0){
		$arr = array('id'=>$cat['id'], 'category'=>$cat['category'], 'parent'=>$cat['parent']);
		array_push($parent, $arr);
	}
}

$first = $parent;
$second = $parent;
$third = $parent;

?>


<div class="font-allerBd uppercase center-text margin-top-10">fourth section</div>

<div class="display-block">
	<div class="width-100 height-10 flex-column justify-content-center align-items-center blue-text font-allerRg">
		<?=$msg;?>
	</div>
</div>

<div class="margin-top-20">
	<div class="container">
		<div class="row">
			<div class="col-6 col-s-12 padding-all-10 relative">
				<form method="POST" enctype="multipart/form-data" action="<?=url_location;?>api/pages/page_four/<?=(($count>0)?'edit':'create');?>.php">
					<!-- set id value if count>0 -->
					<?php if($count>0): ?>
						<div><input type="hidden" name="id" value="<?=$data['id'];?>"></div>
					<?php endif; ?>

					<div class="margin-top-10">
						<div class="uppercase font-allerRg">image 1</div>
						<input type="file" class="input" name="image[]" /><br />
					</div>

					<div class="margin-top-10">
						<div class="uppercase font-allerRg">image 2</div>
						<input type="file" class="input" name="image[]" /><br />
					</div>

					<div class="margin-top-10">
						<div class="uppercase font-allerRg">image 3</div>
						<input type="file" class="input" name="image[]" /><br />
					</div>

					<div class="row">
						<div class="col-4 col-s-12 padding-all-10">
							<div class="font-allerRg">Link 1</div>
							<select name="first">
								<?php foreach($first as $first):?>
									<option value="<?=$first['id'];?>" <?=(($count>0 & $data['first_link'] == $first['id'])?'selected':'');?> ><?=$first['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col-4 col-s-12 padding-all-10">
							<div class="font-allerRg">Link 2</div>
							<select name="second">
								<?php foreach($second as $second):?>
									<option value="<?=$second['id'];?>" <?=(($count>0 & $data['second_link'] == $second['id'])?'selected':'');?> ><?=$second['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col-4 col-s-12 padding-all-10">
							<div class="font-allerRg">Link 3</div>
							<select name="third">
								<?php foreach($third as $third):?>
									<option value="<?=$third['id'];?>" <?=(($count>0 & $data['third_link'] == $third['id'])?'selected':'');?> ><?=$third['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div><button type="submit"><?=(($count>0)?'Edit':'Submit');?></button></div>
				</form>
				<?php if($count>0): ?>
					<div class="absolute bottom-0 right-0">
						<a href="<?=url_location;?>api/pages/page_four/delete.php?id=<?=$data['id'];?>">
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
			<iframe src="/digishop/pages/sectionfour.php"></iframe>
		</div>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/footer.php"; ?>

<?php }else{header('Location: ../admin/');} ?>