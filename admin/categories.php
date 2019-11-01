<?php  
session_start();
session_regenerate_id(true);

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){
?>

<?php include 'includes/head.php'; ?>

<?php include 'includes/nav.php'; ?>

<?php  

$data = null;
$json = file_get_contents(url_location.'api/category/fetch.php');
$data = json_decode($json,true);
$parentData = array();
$childData = array();
$editValue = null;
$msg = null;

if(!empty($data)){
	foreach ($data as $item) {
		if($item['parent'] == 0){
			$arr = array('id'=>(int)$item['id'], 'category'=>$item['category'], 'parent'=>(int)$item['parent']);
			array_push($parentData, $arr);
		}else{
			$childarr = array('id'=>(int)$item['id'], 'category'=>$item['category'], 'parent'=>(int)$item['parent']);
			array_push($childData, $childarr);
		}
	}
}

if(isset($_GET['edit'])){
	$editId = $_GET['edit'];
	foreach($data as $data){
		if($data['id'] == $editId){
			$editValue = $data['category'];
		}
	}
}

if(isset($_GET['msg'])){
	$msg = $_GET['msg'];
}

if(isset($_GET['delete'])){
	header('Location: '.url_location.'api/category/delete.php?delete='.$_GET['delete']);
	exit();
}

?>

<div class="uppercase font-allerBd font-20 bold center-text margin-top-20">Categories</div>

<!-- Break -->

<div class="width-100 height-10 flex-column justify-content-center font-allerBd align-items-center">
	<?=$msg; ?>
</div>

<div class="row">
	<!-- Left -->
	<div class="col-6 col-s-12 col-m-12 padding-all-10">
		<div class="capitalize font-allerBd">
			<span class="border-bottom-1 padding-top-bottom-10">
				<?=((isset($_GET['edit']))?'Edit':'add to');?> category
			</span>
		</div>

		<div class="margin-top-20">
			<form method="POST" action="<?=url_location;?>api/category/<?=((isset($_GET['edit']))?'edit':'add');?>.php">
				<div class="font-allerBd">Parent</div>
				<select name="parent">
					<option value="0">Parent</option>
					<?php if(!empty($parentData)): ?>
						<?php foreach($parentData as $value): ?>
							<option value="<?=$value['id']; ?>"><?=$value['category']; ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select> <br />

				<div class="margin-top-10">
					<div class="capitalize font-allerBd">Category</div>
					<input type="text" name="category" value="<?=((isset($_GET['edit']))?$editValue:'');?>">
				</div>

				<?php  
					if(isset($_GET['edit'])){
				?>

				<div><input type="hidden" name="id" value="<?=$_GET['edit'];?>"></div>

				<?php } ?>

				<div class="margin-top-20">
					<input type="submit" name="" class="white-text deep-grey-bg font-allerBd" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Category">
				</div>
			</form>
		</div>

	</div>

	<?php
		if(isset($_GET['edit'])){
	?>
	<script type="text/javascript">
		let id = <?=$_GET['edit'];?>;
		let json = <?=$json; ?>;

		function matchSelect(a, object){
			let select = document.querySelector('select');
			let len = select.length;
			let editId = a;
			let parent = null;
			
			let jsonLength = object.length;
			object.filter((item)=>{
				if(item.id == editId){
					parent = item.parent;
				}
			});

			for(let i=0; i<len; i++){
				if(select.options[i].value==parent){
					select.options[i].setAttribute('selected', true);
				}
			}
  		}

  		matchSelect(id, json);
	</script>

	<?php  
		}
	?>
	<!-- Right -->
	<div class="col-6 col-s-12 col-m-12 padding-all-10">
		<table class="table bordered allerRg">
			<thead>
				<tr class=""><th></th> <th>Category</th> <th>Parent</th> <th></th></tr>
			</thead>
			<tbody>
				<?php if(!empty($parentData)): ?>
					<?php foreach($parentData as $parent): ?>
						<tr class="blue-bg white-text">
							<td class="font-allerBd font-20 center-text">
								<a href="categories.php?edit=<?=$parent['id']; ?>">
									<span class="yellow-hover cursor-pointer padding-all-5">-</span>
								</a>
							</td> 
							<td><?=$parent['category']; ?></td>	
							<td>Parent</td> 
							<td class="font-allerBd font-20 center-text">
								<a href="categories.php?delete=<?=$parent['id']; ?>">
									<span class="red-hover cursor-pointer padding-all-5">x</span>
								</a>
							</td>
						</tr>
						<?php if(!empty($childData)): ?>
							<?php foreach($childData as $child): ?>
								<?php if($child['parent'] == $parent['id']): ?>
									<tr>
										<td class="font-allerBd font-20 center-text">
											<a href="categories.php?edit=<?=$child['id']; ?>">
												<span class="yellow-hover cursor-pointer padding-all-5">-</span>
											</a>
										</td> 
										<td><?=$child['category']; ?></td>	
										<td><?=$parent['category']; ?></td> 
										<td class="font-allerBd font-20 center-text">
											<a href="categories.php?delete=<?=$child['id']; ?>">
												<span class="red-hover cursor-pointer padding-all-5">x</span>
											</a>
										</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?> <!-- End of foreach for children -->
						<?php endif; ?>
					<?php endforeach; ?> <!-- End of foreach for parents -->
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<!-- <div class="max-width-100 yellow-bg relative">hey</div> -->

<?php include 'includes/footer.php'; ?>

<?php }else{header('Location: ../admin/');} ?>