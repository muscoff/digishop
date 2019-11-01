<?php  
session_start();
session_regenerate_id(true);

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){
?>

<?php include 'includes/head.php'; ?>

<?php include 'includes/nav.php'; ?>

<?php  
// Get Brand
$brand = null;
$brandJson = file_get_contents(url_location.'api/brand/fetch.php');
$brand = json_decode($brandJson, true);

// Get Category
$category = null;
$categoryJson = file_get_contents(url_location.'api/category/fetch.php');
$category = json_decode($categoryJson, true);

// Parent category
$parentCategory = array();
if(!empty($category)){
	foreach ($category as $parent) {
		if($parent['parent']==0){
			$parentCat = array('id'=>(int)$parent['id'], 'category'=>$parent['category'], 'parent'=>(int)$parent['parent']);
			array_push($parentCategory, $parentCat);
		}
	}
}

// child category
$childCategory = array();
if(!empty($category)){
	foreach ($category as $child) {
		if($child['parent'] != 0){
			$childCat = array('id'=>(int)$child['id'], 'category'=>$child['category'], 'parent'=>(int)$child['parent']);
			array_push($childCategory, $childCat);
		}
	}
}

//Child Json
$childJson = json_encode($childCategory);

// Get Products
$product = null;
$product = json_decode(file_get_contents(url_location.'api/product/fetch.php'),true);
$newProductArray = array();

//echo json_encode($product);

//Count number of products
$pCount = count($product);

//Check if array size of product is not 0
if($pCount>0){
	for($p = 0; $p<$pCount; $p++){
		$pParentCat = $product[$p]['parent_cat'];
		$pChildcat = $product[$p]['child_cat'];
		$pBrandItem = $product[$p]['brand'];
		$pCat = null;
		$cCat = null;
		$pBrandValue = null;
		foreach ($parentCategory as $pValue) {
			if($pValue['id'] == $pParentCat){
				$pCat = $pValue['category'];
			}
		}

		foreach ($childCategory as $cValue) {
			if($cValue['id'] == $pChildcat){
				$cCat = $cValue['category'];
			}
		}

		foreach ($brand as $pBrand) {
			if($pBrand['id'] == $pBrandItem){
				$pBrandValue = $pBrand['id'].'-'.$pBrand['brand'];
			}
		}

		$tableCat = $cCat.'-'.$pCat;

		$productArray = array(
			'id'=>$product[$p]['id'], 
			'title'=>$product[$p]['title'], 
			'price'=>$product[$p]['price'],
			'brand'=>$pBrandValue,
			'category'=>$tableCat,
			'featured'=>(int)$product[$p]['featured'],
			'sold'=>$product[$p]['sold'] 
			);

		array_push($newProductArray, $productArray);
	}
}

//echo json_encode($newProductArray);

$msg = isset($_GET['msg'])?$_GET['msg']:null;

?>


<!-- Break -->

<?php  
	if(isset($_GET['add']) || isset($_GET['edit'])){
	
	if(isset($_GET['edit'])){
	// Fetch single
	$prodId = $_GET['edit'];
	$single = json_decode(file_get_contents(url_location.'api/product/fetch_single.php?id='.$prodId),true);	
	
	$sId = $single['id'];
	$sTitle = $single['title'];
	$sBrand = $single['brand'];
	$sParent = $single['parent_cat'];
	$sChild = $single['child_cat'];
	$sPrice = $single['price'];
	$sSize = $single['sizes'];
	$sDescription = $single['description'];

	}
?>

<div class="width-100 height-10 flex-column justify-content-center align-items-center">
	<div class="capitalize bold font-allerBd font-20 border-bottom-1"><?=((isset($_GET['edit']))?'edit':'add a new');?> product</div>
</div><br />

<div class="width-100 <?=((!empty($msg))?'height-10':'');?> flex-column justify-content-center align-items-center font-allerRg blue-text">
	<?=$msg;?>
</div>

<div class="width-90 width-s-100 margin-auto">
	<form method="POST" enctype="multipart/form-data" action="<?=url_location;?>api/product/<?=((isset($_GET['edit']))?'edit':'add');?>.php">
		<div class="row">
			<div class="col-3 col-s-12 col-m-12 padding-all-10">
				<div class="font-allerRg capitalize">title</div>
				<input type="text" name="title" value="<?=((!empty($sTitle))?$sTitle:'');?>" class="transparent border-all-1" />
			</div>	
			<div class="col-3 col-s-12 col-m-12 padding-all-10">
				<div class="font-allerRg capitalize">brand</div>
				<select name="brand">
					<option value=""></option>
					<?php foreach($brand as $brand): ?>
						<option value="<?=$brand['id'];?>" <?=((isset($_GET['edit']) && $brand['id']==$sBrand)?'selected':'');?> ><?=$brand['brand'];?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-3 col-s-12 col-m-12 padding-all-10">
				<div class="font-allerRg capitalize">Parent Category</div>
				<select id="pc" name="parent_cat">
					<option value=""></option>
					<?php foreach($parentCategory as $parentItem): ?>
						<option value="<?=$parentItem['id'];?>" <?=((isset($_GET['edit']) && $parentItem['id']==$sParent)?'selected':'');?> ><?=$parentItem['category'];?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-3 col-s-12 col-m-12 padding-all-10">
				<div class="font-allerRg capitalize">Child Category</div>
				<select id="cc" name="child_cat">
					<option value=""></option>
				</select>
			</div>
			<div class="col-3 col-s-12 col-m-12 padding-all-10">
				<div class="font-allerRg capitalize">Price</div>
				<input type="text" name="price" value="<?=((!empty($sPrice))?$sPrice:'');?>" class="transparent border-all-1" />
			</div>
			<div class="col-3 col-s-12 col-m-12 padding-all-10">
				<div class="font-allerRg capitalize">Sizes & quantity</div>
				<div><button id="sizes" class="transparent border-all-1 font-allerBd">Size & Quantity</button></div>
			</div>
			<div class="col-3 col-s-12 col-m-12 padding-all-10">
				<div class="font-allerRg capitalize">Sizes & Quantity Preview</div>
				<input id="sizeQty" type="text" value="<?=((!empty($sSize))?$sSize:'');?>" name="size" readonly class="transparent border-all-1 font-allerRg" />
			</div>

			<div class="col-3 col-s-12 col-m-12 padding-all-10"></div>	

			<div class="col-6 col-s-12 col-m-12 padding-all-10">
				<div class="font-allerRg capitalize">Image</div>
				<div class="display-<?=((isset($_GET['edit']))?'none':'block');?>"><input type="file" class="input" name="photo[]" multiple max="4" /></div>
				<div class="display-<?=((isset($_GET['edit']))?'block':'none');?>">
					<button class="transparent border-all-1 font-allerBd" id="updateImage">Update images</button>
				</div>
				<div class="display-<?=((isset($_GET['edit']))?'block':'none');?>">
					<input type="hidden" name="productId" value="<?=((!empty($sId))?$sId:'');?>">
				</div>
			</div>

			<div class="col-6 col-s-12 col-m-12 padding-all-10">
				<div class="font-allerRg capitalize">Description</div>
				<textarea name="description" class="transparent allerRg"></textarea>
			</div>

			<!-- button -->
			<div class="col-12 col-s-12 col-m-12">
				<div class="flex-row-reverse">
					<div class="padding-left-10"><input type="submit" name="sub" value="<?=((isset($_GET['edit']))?'Update':'Add');?> product" class="font-allerBd deep-grey-bg white-text"></div>
					<button id="back" class="transparent border-all-1 font-allerBd deep-grey-text">Back</button>
				</div>
			</div>
		</div>
	</form>
	<div class="width-100 height-10"></div>
</div>

<!-- Populate Child Category JS -->
<script type="text/javascript">
	const childJson = <?=$childJson?>;

	document.querySelector('#pc').addEventListener('change', e=>{
		let parentC = document.querySelector('#pc');
		let selectedVal = parentC[parentC.selectedIndex].value;

		let childDiv = document.getElementById('cc');
		let output = '<option value=""></option>';

		childArray = [];
		childArray = childJson.filter(child=>child.parent==selectedVal);
		childArray.forEach(child=>output+=`<option value="${child.id}">${child.category}</option>`);
		childDiv.innerHTML = output;
	});

</script>

<!-- Fake modal -->
<div class="width-100 height-100 black-bg opacity-05 fixed top-0" id="bg"></div>
<div id="modal" class="width-60 width-s-100 width-m-100 white-bg absolute left-20 left-s-0 left-m-0 top-10 round-5 padding-all-10 font-allerRg">
	<div class="width-100 height-10 flex-column justify-content-center align-items-center border-bottom-1">
		Size and Quantities
	</div>
	<?php
	 	$sizeArray = array();
	 	$lengthArray = array();
	 	$quantityArray = array();

	 	if(!empty($sSize)){
	 		$explodeSize = explode(',', $sSize);
	 		foreach ($explodeSize as $explodeSize) {
	 			//explode to separate quantity and size-length
	 			$explodeToGetLength = explode('-', $explodeSize);
	 			//let l=length, s=size and q=quantity
	 			$q = $explodeToGetLength[1]; // this is the quantity
	 			//Now explode to get the size and length
	 			$explodeToGetSize = explode(':', $explodeToGetLength[0]);
	 			$s = $explodeToGetSize[0]; //this is the size
	 			$l = $explodeToGetSize[1]; //this is the length
	 			// push to the respective arrays
	 			array_push($sizeArray, $s);
	 			array_push($lengthArray, $l);
	 			array_push($quantityArray, $q);
	 		}
	 	}
	 	$countSize = count($sizeArray);
	 ?>
	<div class="row">
		<?php for($i=0; $i<12; $i++): ?>
			<div class="col-2 col-s-4  col-m-4 padding-all-10">
				<div class="font-allerRg deep-grey-text">Size</div>
				<input type="text" value="<?=((!empty($sSize) & $i<$countSize)?$sizeArray[$i]:'');?>" name="" class="size font-allerRg">
			</div>
			<div class="col-2 col-s-4 col-m-4 padding-all-10">
				<div class="font-allerRg deep-grey-text">Length</div>
				<input type="text" value="<?=((!empty($sSize) & $i<$countSize)?$lengthArray[$i]:'');?>" name="" class="length font-allerRg">
			</div>
			<div class="col-2 col-s-4 col-m-4 padding-all-10">
				<div class="font-allerRg deep-grey-text">Quantity</div>
				<input type="number" value="<?=((!empty($sSize) & $i<$countSize)?$quantityArray[$i]:'');?>" class="input quantity" min="0" max="1000" name="" class="font-allerRg">
			</div>
		<?php endfor; ?>
	</div>
	<div class="width-100 width-s-100 height-10 margin-top-20">
		<div class="flex-row-reverse">
			<div class="padding-left-10"><button id="cancel" class="transparent border-all-1">Cancel</button></div> 
			<div><button class="deep-grey-bg white-text" id="save">Save</button></div>
		</div>
	</div>
</div>

<!-- Modal, Back Button, Save Button, Cancel Button -->
<script type="text/javascript">
	//Back Button
	document.querySelector('#back').addEventListener('click', e=>{
		e.preventDefault();
		console.log('clicked');
		window.location = 'product.php';
	});

	// Open Size Modal
	document.querySelector('#sizes').addEventListener('click', e=>{
		e.preventDefault();
		let bg = document.querySelector('#bg');
		bg.style.display = 'block';
		let modal = document.querySelector('#modal');
		modal.style.display = 'block';
	});

	// Cancel Button
	document.querySelector('#cancel').addEventListener('click', e=>{
		let bg = document.querySelector('#bg');
		bg.style.display = 'none';
		let modal = document.querySelector('#modal');
		modal.style.display = 'none';
	});

	// Save Button For Modal
	document.querySelector('#save').addEventListener('click', e=>{
		let size = document.querySelectorAll('.size');
		let length = document.querySelectorAll('.length');
		let quantity = document.querySelectorAll('.quantity');
		let holder = document.querySelector('#sizeQty');

		let sizeValue = '';

		let count = size.length;

		for(let i=0; i<count; i++){
			if(size[i].value !='' & length[i].value !='' & quantity[i].value !=''){
				sizeValue = sizeValue +size[i].value + ':'+length[i].value + '-'+quantity[i].value+',';
			}
		}

		holder.setAttribute('value', sizeValue);

		function closeM(){
			let bg = document.querySelector('#bg');
			bg.style.display = 'none';
			let modal = document.querySelector('#modal');
			modal.style.display = 'none';
		}
		setTimeout(closeM,500);
	});
</script>


<?php  
}//End of GET['add'] OR GET['edit']
?>

<?php
if(isset($_GET['edit']) || isset($_GET['add'])){
	if(isset($_GET['edit'])){
?>

<!-- $_GET['edit'] auto populate selected parent's children's values -->
<script type="text/javascript">
	function selectedItem(){
		let parent = document.querySelector('#pc');
		let count = parent.length;

		let childDiv = document.getElementById('cc');
		let output = '<option value=""></option>';

		for(let i=0; i<count; i++){
			if(parent.options[i].selected){
				let sel = parent[parent.selectedIndex].value;
				
				childArray = [];
				childArray = childJson.filter(child=>child.parent==sel);
				childArray.forEach(child=>output+=`<option value="${child.id}">${child.category}</option>`);
				childDiv.innerHTML = output;
			}
		}
	}
	selectedItem();

	function selectChild(child){
		let children = document.querySelector('#cc');
		let count = children.length;

		for(let i = 0; i<count; i++){
			if(children.options[i].value == child){
				children.options[i].setAttribute('selected', true);
			}
		}
	}
	selectChild(<?=$sChild;?>);

	function setTextAreaValue(textValue){
		let textArea = document.querySelector('textarea');
		textArea.innerHTML = textValue;
	}
	setTextAreaValue("<?=$sDescription;?>");

	document.querySelector('#updateImage').addEventListener('click', e=>{
		e.preventDefault();
		window.location = 'update_images.php?id=<?=$sId;?>';
	});
</script>

<?php
}
}  
else{
?>

<div class="uppercase font-allerBd font-20 bold center-text margin-top-20">Products</div>


<div class="width-100 height-10"></div>

<div class="width-100 height-5 flex-row-reverse align-items-center">
	<div class="padding-right-10">
		<a href="product.php?add=1">
			<button class="btn transparent border-all-1">Add Product</button>
		</a>
	</div>
</div>

<div class="width-100 <?=((!empty($msg))?'height-10':'');?> flex-column justify-content-center align-items-center font-allerRg blue-text">
	<?=$msg;?>
</div>

<div class="width-100 <?=((empty($msg))?'height-5':'');?>"></div>

<table class="table bordered">
	<thead class="allerBd">
		<tr><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th><th></th></tr>
	</thead>
	<tbody class="allerRg">
		<?php foreach($newProductArray as $newProduct): ?>
		<tr>
			<td class="center-text font-20">
				<a href="product.php?add=1&edit=<?=$newProduct['id'];?>">
					<span class="yellow-hover padding-all-10">-</span>
				</a>
			</td>
			<td><?=$newProduct['title'];?></td>
			<td><?=$newProduct['price'];?></td>
			<td><?=$newProduct['category'];?></td>
			<td>
				<a href="<?=url_location;?>api/product/update_featured.php?featured=<?=(($newProduct['featured']==1)?0:1);?>&productId=<?=$newProduct['id'];?>">
					<span class="padding-all-5 padding-s-all-5 padding-m-all-5 light-grey-bg font-s-12 font-m-12">
						<?=(($newProduct['featured'] == 1)?'- Featured':'+ Not Featured');?>	
					</span>
				</a>
			</td>
			<td><?=$newProduct['sold'];?></td>
			<td class="center-text font-20">
				<a href="<?=url_location;?>api/product/delete.php?delete=<?=$newProduct['id'];?>">
					<span class="red-hover padding-all-10">x</span>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php  
}
?>


<?php include 'includes/footer.php'; ?>

<?php }else{header('Location: ../admin/');} ?>