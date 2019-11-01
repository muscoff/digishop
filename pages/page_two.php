<?php  
session_start();
session_regenerate_id(true);

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){
?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/head.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/nav.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/section_nav.php"; ?>

<?php  

//Get Category
$data = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);

$parent = array();

foreach ($data as $data) {
	if($data['parent']==0){
		$arr = array('id'=>$data['id'], 'category'=>$data['category'], 'parent'=>$data['parent']);
		array_push($parent, $arr);
	}
}

$firstParent = $parent;
$secondParent = $parent;

//Fetch Data to compare
$pageTwoData = json_decode(file_get_contents(url_location.'api/pages/page_two/fetch.php'), true);
$count = count($pageTwoData);

$firstLink = $pageTwoData['first_link'];
$secondLink = $pageTwoData['second_link'];


$msg = isset($_GET['msg'])?$_GET['msg']:null;

?>


<div class="font-allerBd uppercase center-text margin-top-10">second section</div>

<div class="margin-top-10 display-<?=((!empty($msg))?'block':'none');?>">
	<div class="width-100 height-10 flex-column justify-content-center align-items-center blue-text font-allerRg">
		<?=$msg;?>
	</div>
</div>

<div class="margin-top-20">
	<div class="container">
		<div class="row">
			<div class="col-6 col-s-12 padding-all-10 relative">
				<form method="POST" enctype="multipart/form-data" action="<?=url_location;?>api/pages/page_two/<?=(($count>0)?'edit':'create');?>.php">
					<div>
						<div class="font-allerRg uppercase">Upload Background Image</div>
						<input type="file" class="input" name="image" />
					</div><br />

					<?php if($count>0): ?>
						<div><input type="hidden" name="id" value="<?=$pageTwoData['id'];?>"></div>
					<?php endif; ?>

					<div>
						<div class="font-allerRg uppercase">first caption</div>
						<input type="text" name="first_cap" placeholder="new arrival" value="<?=(($count>0)?$pageTwoData['first_cap']:'');?>" />
					</div><br />

					<div>
						<div class="font-allerRg uppercase">Second caption</div>
						<input type="text" name="second_cap" placeholder="good things" value="<?=(($count>0)?$pageTwoData['second_cap']:'');?>" />
					</div><br />

					<div>
						<div class="font-allerRg uppercase">third caption</div>
						<input type="text" name="third_cap" placeholder="are happening" value="<?=(($count>0)?$pageTwoData['third_cap']:'');?>" />
					</div><br />

					<div class="row">
						<div class="col-6 col-s-12 padding-all-10 font-allerRg">
							<div>First Link</div>
							<select name="first">
								<?php foreach($firstParent as $firstData): ?>
									<option value="<?=$firstData['id'];?>" <?=(($count>0 & $firstLink==$firstData['id'])?'selected':'');?> ><?=$firstData['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col-6 col-s-12 padding-all-10 font-allerRg">
							<div>Second Link</div>
							<select name="second">
								<?php foreach($secondParent as $secondData): ?>
									<option value="<?=$secondData['id'];?>" <?=(($count>0 & $secondLink == $secondData['id'])?'selected':'');?> ><?=$secondData['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="margin-top-10">
						<button type="submit">Submit</button>
					</div>
				</form>
				<?php if($count>0): ?>
				<div class="absolute bottom-0 right-0">
					<a href="<?=url_location;?>api/pages/page_two/delete.php?id=<?=$pageTwoData['id'];?>">
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

<div class="width-100 height-100 height-s-50 overflow-hidden margin-top-20">
	<div class="center-text font-allerBd">Preview</div>
	<div class="width-100 height-100 margin-top-20">
		<div class="full iframe">
			<iframe src="/digishop/pages/sectiontwo.php"></iframe>
		</div>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/footer.php"; ?>

<?php }else{header('Location: ../admin/');} ?>