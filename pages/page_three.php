<?php  
session_start();
session_regenerate_id(true);

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){
?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/head.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/nav.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/section_nav.php"; ?>

<?php  

//Fetch page data
$data = json_decode(file_get_contents(url_location.'api/pages/page_three/fetch.php'),true);
$count = count($data);

//Fetch category
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);
$parent = array();

foreach ($cat as $cat) {
	if($cat['parent']==0){
		$arr = array('id'=>$cat['id'], 'category'=>$cat['category'], 'parent'=>$cat['parent']);
		array_push($parent, $arr);
	}
}

$firstLink = $parent;
$secondLink = $parent;

$msg = isset($_GET['msg'])?$_GET['msg']:null;

?>


<div class="font-allerBd uppercase center-text margin-top-10">third section</div>

<div class="display-<?=((!empty($msg))?'block':'none');?>">
	<div class="width-100 height-10 flex-column justify-content-center align-items-center font-allerRg blue-text">
		<?=$msg;?>
	</div>
</div>

<div class="margin-top-20">
	<div class="container">
		<div class="row">
			<div class="col-6 col-s-12 padding-all-10 relative">
				<form method="POST" action="<?=url_location;?>api/pages/page_three/<?=(($count>0)?'edit':'create');?>.php">
					<div>
						<div class="font-allerRg uppercase">first caption</div>
						<input type="text" name="first_cap" placeholder="afterpay" value="<?=(($count>0)?$data['first_cap']:'');?>" />
					</div><br />

					<?php if($count>0): ?>
						<div><input type="hidden" name="id" value="<?=$data['id'];?>"></div>
					<?php endif; ?>

					<div>
						<div class="font-allerRg uppercase">Second caption</div>
						<input type="text" name="second_cap" placeholder="wear now. pay later" value="<?=(($count>0)?$data['second_cap']:'');?>" />
					</div><br />

					<div class="row">
						<div class="col-6 col-s-12 padding-all-10 font-allerRg">
							<div>First Link</div>
							<select name="first">
								<?php foreach($firstLink as $first): ?>
									<option value="<?=$first['id'];?>" <?=(($count>0 & $data['first_link']==$first['id'])?'selected':'');?> ><?=$first['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col-6 col-s-12 padding-all-10 font-allerRg">
							<div>Second Link</div>
							<select name="second">
								<?php foreach($secondLink as $second): ?>
									<option value="<?=$second['id'];?>" <?=(($count>0 & $data['second_link']==$second['id'])?'selected':'');?> ><?=$second['category'];?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="margin-top-10">
						<button type="submit"><?=(($count>0)?'Edit':'Submit');?></button>
					</div>
				</form>
				<?php if($count>0): ?>
					<div class="absolute bottom-0 right-0">
						<a href="<?=url_location;?>api/pages/page_three/delete.php?id=<?=$data['id'];?>">
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

<div class="width-100 height-50 height-s-50 overflow-hidden margin-top-20">
	<div class="center-text font-allerBd">Preview</div>
	<div class="width-100 height-100 margin-top-20">
		<div class="full iframe">
			<iframe src="/digishop/pages/sectionthree.php"></iframe>
		</div>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/admin/includes/footer.php"; ?>

<?php }else{header('Location: ../admin/');} ?>