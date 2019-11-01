<?php  
session_start();
session_regenerate_id(true);
if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){
?>

<?php include 'includes/head.php'; ?>

<?php include 'includes/nav.php'; ?>

<?php  
$data = null;
$data = json_decode(file_get_contents(url_location.'api/brand/fetch.php'), true);

$msg = null;

if(isset($_GET['msg'])){
	$msg = $_GET['msg'];
}

$edit_name = null;

?>

<div class="uppercase font-allerBd font-20 bold center-text margin-top-20">Brands</div>

<!-- Break -->

<div class="width-100 height-10"></div>

<?php  
	if(isset($_GET['edit'])){
		$edit_id = $_GET['edit'];

		foreach ($data as $item) {
			if($item['id'] == $edit_id){
				$edit_name = $item['brand'];
			}
		}
?>

<div class="width-30 width-s-100 width-m-90 padding-all-10 margin-auto">
	<form method="POST" action="<?=url_location;?>api/brand/edit.php">
		<div><input type="hidden" name="id" value="<?=$_GET['edit']; ?>"></div>
		<div><input type="text" name="brand" value="<?=$edit_name; ?>" placeholder="Brand Name"></div><br />
		<div><input type="submit" value="Edit Brand" class="deep-grey-bg white-text" name=""></div>
	</form>
</div>

<?php  
}else{
?>

<div class="width-30 width-s-100 width-m-90 padding-all-10 margin-auto">
	<form method="POST" action="<?=url_location;?>api/brand/add.php">
		<div><input type="text" name="brand" placeholder="Brand Name"></div><br />
		<div><input type="submit" value="Add Brand" class="deep-grey-bg white-text" name=""></div>
	</form>
</div>

<?php
}
?>

<!-- break -->
<div class="width-100 height-10 flex-column justify-content-center align-items-center">
	<span class="font-allerBd"><?=$msg; ?></span>
</div>

<div class="width-40 width-s-100 width-m-90 padding-all-10 margin-auto">
	<table class="table light-grey-bg">
		<thead>
			<tr><th></th> <th>Brand</th> <th></th></tr>
		</thead>
		<tbody>
			<?php if(!empty($data)): ?>
			<?php foreach($data as $value): ?>
			<tr>
				<td class="center-text cursor-pointer font-20 font-allerRg" title="edit">
					<a href="<?=url_location;?>admin/brand.php?edit=<?= $value['id'];?>">
						<span class="yellow-hover">-</span>
					</a>
				</td>
				<td><?=$value['brand']; ?></td>
				<td class="center-text cursor-pointer font-20 font-allerRg" title="delete">
					<a href="<?=url_location;?>api/brand/delete.php?delete=<?= $value['id'];?>">
						<span class="red-hover">x</span>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<?php include 'includes/footer.php'; ?>

<?php }else{header('Location: ../admin/');} ?>