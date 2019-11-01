<?php  
session_start();
session_regenerate_id(true);

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){
?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/head.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/nav.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/section_nav.php"; ?>

<?php  

$msg = isset($_GET['msg'])?$_GET['msg']:null;

//Fetch Category
$data = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);

$parent = array();

foreach ($data as $data) {
	if($data['parent'] == 0){
		$parentArray = array('id'=>$data['id'], 'category'=>$data['category'], 'parent'=>$data['parent']);
		array_push($parent, $parentArray);
	}
}

$first = $parent;
$second = $parent;
$third = $parent;

//Fetch Page data
$pageData = json_decode(file_get_contents(url_location.'api/pages/page_one/fetch.php'),true);
$pageDataCount = count($pageData);
$first_cap = $pageData['first_cap'];
$second_cap = $pageData['second_cap'];
$first_link = $pageData['first_link'];
$second_link = $pageData['second_link'];
$third_link = $pageData['third_link'];

?>


<div class="font-allerBd uppercase center-text margin-top-10">first section</div>

<div class="display-<?=((!empty($msg))?'block':'none');?> center-text font-allerRg">
	<div class="width-100 height-10 flex-column justify-content-center align-items-center red-text">
		<?=$msg;?>
	</div>
</div>

<div class="margin-top-20">
	<div class="container">
		<div class="row">
			<div class="col-6 col-s-12 padding-all-10 relative">
				<form method="POST" enctype="multipart/form-data" action="<?=url_location;?>api/pages/page_one/<?=(($pageDataCount>0)?'edit':'create');?>.php">
					<div>
						<div class="font-allerRg uppercase">Upload Background Image</div>
						<input type="file" class="input" name="image" />
					</div><br />

					<?php if($pageDataCount>0): ?>
						<div>
							<input type="hidden" name="id" value="<?=$pageData['id'];?>">
						</div>
					<?php endif; ?>

					<div>
						<div class="font-allerRg uppercase">first caption</div>
						<input type="text" name="first_cap" placeholder="end of season sale" value="<?=(($pageDataCount>0)?$first_cap:'');?>" />
					</div><br />

					<div>
						<div class="font-allerRg uppercase">second caption</div>
						<input type="text" name="second_cap" placeholder="get 50% of your selected style" value="<?=(($pageDataCount>0)?$second_cap:'');?>" />
					</div><br />

					<div class="row">
						<div class="col-4 col-s-12 padding-all-10 font-allerRg">
							<div>First Link</div>
							<select name="first_link">
								<?php foreach($first as $first): ?>
									<option value="<?=$first['id'];?>" <?=(($pageDataCount>0 & $first_link==$first['id'])?'selected':'');?> ><?=$first['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col-4 col-s-12 padding-all-10 font-allerRg">
							<div>Second Link</div>
							<select name="second_link">
								<?php foreach($second as $second): ?>
									<option value="<?=$second['id'];?>" <?=(($pageDataCount>0 & $second_link == $second['id'])?'selected':'');?> ><?=$second['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col-4 col-s-12 padding-all-10 font-allerRg">
							<div>Third Link</div>
							<select name="third_link">
								<?php foreach($third as $third): ?>
									<option value="<?=$third['id'];?>" <?=(($pageDataCount>0 & $third_link==$third['id'])?'selected':'');?> ><?=$third['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="margin-top-10">
						<button type="submit"><?=(($pageDataCount>0)?'Edit':'Submit');?></button>
					</div>
				</form>
				<?php if($pageDataCount>0): ?>
				<div class="absolute bottom-0 right-0">
					<a href="<?url_location;?>api/pages/page_one/delete.php?id=<?=$pageData['id'];?>">
						<button class="transparent border-all-1">Delete</button>
					</a>
				</div>
				<?php endif; ?>
			</div>
			<div class="col-6 col-s-12 padding-all-10">
				<div class="uppercase center-text font-allerBd">section map</div>
			</div>
		</div>
	</div>
</div>

<div class="width-100 height-50 overflow-hidden margin-top-20">
	<div class="center-text font-allerBd">Preview</div>
	<div class="width-100 height-100 margin-top-20">
		<div class="full iframe">
			<iframe src="/digishop/pages/sectionone.php"></iframe>
		</div>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/footer.php"; ?>

<?php }else{header('Location: ../admin/');} ?>