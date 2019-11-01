<?php 
session_start();
//session_regenerate_id(true);

if(!empty($_SESSION['id'])):
if(isset($_GET['id'])):

$sentmsg = isset($_GET['msg'])?$_GET['msg']:null;
?>

<!-- head -->
<?php include "includes/head.php"; ?>

<!-- top nav -->
<?php include "includes/topnav.php"; ?>

<!-- navbar -->
<?php include "includes/nav.php"; ?>

<!-- break -->
<div class="padding-all-10 center-text">
	<span id="result" class="font-allerRg blue-text"><?=$sentmsg;?></span>
</div>

<?php  

$id = $_GET['id'];
$data = json_decode(file_get_contents(url_location.'api/product/fetch_single.php?id='.$id),true);
//Get images and explode to get product face and sub images
$images = $data['image'];
$explodeImage = explode(',', $images);
$productFace = null;
$subImages = array();
foreach ($explodeImage as $key => $value) {
	if($key == 0){
		$productFace = $value;
	}

	if($key > 0){
		array_push($subImages, $value);
	}
}

//Get sizes and explode to get respective sizes
$size = $data['sizes'];
$explodeSize = explode(',', $size);
$sizeArray = array();
$lengthArray = array();
foreach ($explodeSize as $explodeSize) {
	$explodeSingleSize = explode(':', $explodeSize);
	//Get size - That is either S, M or L
	$itemSize = $explodeSingleSize[0];

	//length and quantity
	$lengthQuantity = $explodeSingleSize[1];
	//explode to get length and quantity
	$lq = explode('-', $lengthQuantity);
	$length = $lq[0];
	$quantity = $lq[1];
	array_push($sizeArray, $itemSize);
	array_push($lengthArray, $length);
}

?>

<div class="container">
	<div class="flex-row flex-wrap">
		<div class="col-6 col-s-12 col-m-12">
			<div class="width-auto width-s-100 padding-all-10">
				<!-- main image -->
				<div id="main-switch" class="max-width-100 max-height-90 overflow-hidden">
					<div id="magnigy" class="img-container-100 relative">
						<img src="<?=$productFace;?>" />
					</div>
				</div>
				<!-- sub images -->
				<div id="switch" class="flex-row margin-top-10">
					<?php foreach($subImages as $subImage): ?>
					<div class="col-3 col-s-4 col-m-4 padding-all-10">
						<div class="width-auto height-20 img-container-100">
							<img src="<?=$subImage;?>" />
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="col-6 col-s-12 col-m-12">
			<div class="padding-all-10">
				<div class="capitalize font-allerBd font-20"><?=$data['title'];?></div>
				<div class="uppercase grey-text font-allerRg font-12 display-none">levis premium</div>

				<div class="margin-top-10 font-allerBd font-20">$<?=$data['price'];?></div>
				<div class="font-12 font-allerRg grey-text">Pay with mobile money, bitcoin or credit card</div>

				<div class="margin-top-10 uppercase font-allerBd">description</div>
				<div class="font-13 grey-text">
					<?=$data['description'];?>
				</div>

				<div class="margin-top-20 uppercase font-allerRg font-14">
					<span class="border-all-1 padding-all-10 red-text">what's your size?</span>
				</div>

				<!-- sizes -->
				<div class="margin-top-20">
					<div class="grey-text uppercase padding-all-10 font-allerBd">size</div>
					<div class="row" id="size">
						<?php foreach($sizeArray as $itemsize): ?>
						<div class="col-2 cursor-pointer">
							<div class="border-all-1 center-text padding-all-10 deep-grey-white-text-hover">
								<?=strtoupper($itemsize);?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- length -->
				<div class="margin-top-20">
					<div class="grey-text uppercase padding-all-10 font-allerBd">length</div>
					<div class="row" id="length">
						<?php foreach($lengthArray as $itemlength): ?>
						<div class="col-2 cursor-pointer">
							<div class="border-all-1 center-text padding-all-10 deep-grey-white-text-hover">
								<?=$itemlength;?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>


				<!-- info to add -->
				<div id="cart-info" data-id="<?=$data['id'];?>" data-size="" data-length="" data-quantity=""></div>
				<!-- quantity and add -->
				<div class="margin-top-20">
					<div class="row">
							<div class="col-4 col-s-12 col-m-12 col-l-12">
								<form method="POST" action="add.php">
									<input type="hidden" name="id" id="id" value="<?=$data['id'];?>">
									<input type="hidden" name="size" value="" id="formSize">
									<input type="hidden" name="length" value="" id="formLength">
								<p>Quantity</p>
								<input type="text" name="quantity" id="quantity">
								<div class="margin-top-20">
									<button type="submit" id="add-cart" class="red-bg width-100 font-allerBd white-text">Add to cart</button>
								</div>
								</form>
							</div>
							<div class="col-8"></div>
							<div class="col-6 col-s-12 col-m-12 col-l-12 margin-top-10">
								<!-- <div class="width-auto height-10 btn red-bg padding-all-10 cursor-pointer white-text font-allerBd uppercase" id="add-to-cart">
									Add to cart
								</div> -->
								<a href="product.php">
									<div class="padding-top-bottom-10 blue-text">Go back to shopping site</div>
								</a>
							</div>
						<div class="col-6"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Add to cart js -->
<script type="text/javascript">
	function getSize(){
		let sizes = document.querySelectorAll('#size div div');
		let count = sizes.length;

		let cartInfo = document.querySelector('#formSize');
		
		for(let i=0; i<count; i++){
			sizes[i].addEventListener('click', e=>{
				let size = sizes[i].innerHTML;
				cartInfo.setAttribute('value', size);

				function addBg(){
					let mySizes = document.querySelectorAll('#size div div');
					let mySizesLength = mySizes.length;

					for(let y = 0; y<mySizesLength; y++){
						if(y != i){
							let itemList = mySizes[y].classList;
							let itemNumber = itemList.length;
							for(let x = 0; x<itemNumber; x++){
								if(itemList[x] == "color-bg-grey"){
									mySizes[y].classList.remove('color-bg-grey');
								}
							}
							itemList = mySizes[y].classList;
							//console.log(itemList);
						}else{
							mySizes[y].classList.add('color-bg-grey');
						}
					}
				}
				addBg();
			});
		}
	}
	getSize();

	function getLength(){
		let len = document.querySelectorAll('#length div div');
		let count = len.length;

		let cartInfo = document.querySelector('#formLength');
		
		for(let i=0; i<count; i++){
			len[i].addEventListener('click', e=>{
				let itemLength = len[i].innerHTML;
				cartInfo.setAttribute('value', itemLength);

				function addBg(){
					let myLength = document.querySelectorAll('#length div div');
					let myLengthCount = myLength.length;

					for(let y = 0; y<myLengthCount; y++){
						if(y != i){
							let itemList = myLength[y].classList;
							let itemNumber = itemList.length;
							for(let x = 0; x<itemNumber; x++){
								if(itemList[x] == "color-bg-grey"){
									myLength[y].classList.remove('color-bg-grey');
								}
							}
							itemList = myLength[y].classList;
							//console.log(itemList);
						}else{
							myLength[y].classList.add('color-bg-grey');
						}
					}
				}
				addBg();
			});
		}
	}
	getLength();

	document.querySelector('#add-cart').addEventListener('click', e=>{
		e.preventDefault();
		let id = document.querySelector('#id').value;
		let size = document.querySelector('#formSize').value;
		let length = document.querySelector('#formLength').value;
		let quantity = document.querySelector('#quantity').value;

		const url = '<?=url_location."add_cart.php";?>';

		if(quantity != '' & size != '' & length != '' & id !=''){

			let formData = new FormData();
			formData.append('id', id);
			formData.append('size', size);
			formData.append('length', length);
			formData.append('quantity', quantity);

			fetch(url, {method: 'POST', body: formData})
			.then(response=>response.json())
			.then(response=>{
				let result = document.querySelector('#result');
				result.innerHTML = response.msg;
			})
			.catch(error=>console.log(error));
		}else{
			let result = document.querySelector('#result');
			result.innerHTML = 'Please make sure to select your desired size and length and also input the quantity. thank you';
		}
	});

	// function getQuantity(){
	// 	let quantity = document.querySelector('#quantity').value;
	// 	let cartInfo = document.querySelector('#cart-info');
	// 	cartInfo.setAttribute('data-quantity', quantity);
	// }
	// document.querySelector('#quantity').addEventListener('input', getQuantity);
	// document.querySelector('#quantity').addEventListener('keyup', getQuantity);
	// document.querySelector('#quantity').addEventListener('blur', getQuantity);

	// document.querySelector('#add-to-cart').addEventListener('click', e=>{
	// 	let cartInfo = document.querySelector('#cart-info');
	// 	let id = cartInfo.getAttribute('data-id');
	// 	let quantity = cartInfo.getAttribute('data-quantity');
	// 	let size = cartInfo.getAttribute('data-size');
	// 	let dressLength = cartInfo.getAttribute('data-length');

	// 	if(quantity == '' || size == '' || dressLength == ''){
	// 		alert('Please make sure to include quantity, size and dress length to continue');
	// 	}else{
	// 	let formData = new FormData();
	// 	formData.append('id', id);
	// 	formData.append('quantity', quantity);
	// 	formData.append('size', size);
	// 	formData.append('length', dressLength);

	// 	fetch('<?=url_location;?>add.php', {
	// 		// headers:{}
	// 		method: 'POST',
	// 		body: formData
	// 	})
	// 	.then(response=>response.json())
	// 	// .then(res=>{alert(res.msg);})
	// 	.then(res=>console.log(res))
	// 	.catch(error=>{console.log(error);});
	// 	}
	// });
</script>

<!-- Image switch and magnify js -->
<script type="text/javascript">
	function switchImage(){
		let switch_Image = document.querySelectorAll('#switch div div img');
		let len = switch_Image.length;
		
		let main_Image = document.querySelector('#main-switch div img');

		for(let i=0; i<len; i++){
			switch_Image[i].addEventListener('click', e=>{
				let attr =  switch_Image[i].getAttribute('src');

				//main attr
				let main_attr = main_Image.getAttribute('src');

				main_Image.setAttribute('src', attr);
				switch_Image[i].setAttribute('src', main_attr);
			});
		}
	}
	switchImage();

	//magnify glass
	function magnify(imgId, zoom){
		var id = imgId;
		var img, glass, w, h, bw, source;
		img = document.querySelector('#'+imgId+' img');

		glass = document.createElement('div');
		glass.className = 'magnifier';

		//Insert into document before the image
		img.parentElement.insertBefore(glass, img);

		function getSource(){
			img = document.querySelector('#'+imgId+' img');
			source = img.src;
			return source;
		}

		function runFxn(){
			//console.log(source);
			getSource();
			setTimeout(runFxn, 500);
		}
		runFxn();

		function setBG(){
			glass.style.backgroundImage = "url('"+source+"')";
			glass.style.backgroundRepeat = 'no-repeat';
			glass.style.backgroundSize = (img.width * zoom)+"px " + (img.height * zoom) +"px";
			setTimeout(setBG, 500);
		}
		setBG();

		w = glass.offsetWidth/2;
		h = glass.offsetHeight/2;
		bw = 3;

		glass.addEventListener('mousemove', moveMagnifier);
		img.addEventListener('mousemove', moveMagnifier);

		function moveMagnifier(e){
			var pos, x, y;
			e.preventDefault();
			pos = getCursorPostion(e);
			x = pos.x;
			y = pos.y;

			if(x> img.width - (w/zoom)){x = img.width - (w/zoom);}
			if (x < w / zoom) {x = w / zoom;}
			if (y > img.height - (h / zoom)) {y = img.height - (h / zoom);}
    		if (y < h / zoom) {y = h / zoom;}

			// Set position of magnifying glass
			glass.style.left = (x - w) + "px";
    		glass.style.top = (y - h) + "px";

			// display what the magnifier sees
			glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
		}

		function getCursorPostion(e){
			var a, x=0, y=0;
			a = img.getBoundingClientRect();
			e = e || window.event;

			x = e.pageX - a.left;
			y = e.pageY - a.top;

			//Scrolling consideration
			x = x - window.pageXOffset;
			y = y - window.pageYOffset;

			return {x:x, y:y};
		}
	}

	var screenWidth;

	function checkScreenWidth(){
		screenWidth = window.innerWidth;
		setTimeout(checkScreenWidth, 500);
	}
	checkScreenWidth();

	//screenWidth = window.innerWidth;
	if(screenWidth > 920){
		magnify('magnigy', 3);
	}
</script>

<!-- side nav -->
<?php include "includes/side_nav.php"; ?>

<!-- footer -->
<?php include "includes/footer.php"; ?>

<!-- script -->
<?php include "includes/script.php"; ?>

<!-- tail -->
<?php include "includes/tail.php"; ?>

<?php endif; ?> <!-- End if for Get id -->

<?php endif; ?> 