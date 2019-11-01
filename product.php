<?php  
	session_start();
	//session_regenerate_id(true);

	if(!empty($_SESSION['id'])){
?>

<!-- head -->
<?php include "includes/head.php"; ?>

<!-- top nav -->
<?php include "includes/topnav.php"; ?>

<!-- nav -->
<?php include "includes/nav.php"; ?>

<?php 
	$data = json_decode(file_get_contents(url_location.'api/product/fetch.php'),true);
	$product = array();
	$sizeArray = array();
	$lengthArray = array();
	foreach($data as $data){
		if($data['featured'] == 1){
			$id = $data['id'];
			$title = $data['title'];
			$price = $data['price'];
			$image = $data['image'];
			$explodeImage = explode(',', $image);
			$image = $explodeImage[0];

			//Get sizes
			$sizeList = $data['sizes'];
			$explodeSizeList = explode(',', $sizeList);
			foreach ($explodeSizeList as $explodeSizeList) {
				$sizeItem = explode('-', $explodeSizeList);
				$sizeItem = $sizeItem[0];
				$explodeSizeItem = explode(':', $sizeItem);
				array_push($sizeArray, strtoupper($explodeSizeItem[0]));
				array_push($lengthArray, $explodeSizeItem[1]);
			}

			$arr = array('id'=>$id, 'title'=>$title, 'price'=>$price, 'image'=>$image);
			array_push($product, $arr);
		}
	}

	//Define new Array to hold sizes
	$sizeDisplay = array();


	//Sort sizes in ascending order
	sort($sizeArray);
	$uniqueSize = array_unique($sizeArray);
	foreach ($uniqueSize as $key => $uniqueSize) {
		array_push($sizeDisplay, ($uniqueSize));
	}

	//Define new Array to hold length
	$lengthDisplay = array();

	//sort length in ascending order
	sort($lengthArray);
	$uniqueLength = array_unique($lengthArray);
	foreach ($uniqueLength as $key => $uniqueLength) {
		array_push($lengthDisplay, $uniqueLength);
	}
	// if(isset($_GET['productId'])){
	// 	$msg = 'cool';
?>

<div class="padding-all-10">
	<div class="row">
		<!-- left -->
		<div class="col-3 col-s-12 col-m-12 col-l-12 padding-all-10 padding-s-all-2">
			
			<div class="uppercase font-20 font-allerBd deep-grey-text border-bottom-1">filter</div>
			<div class="uppercase font-17 font-allerRg grey-text margin-top-10">size</div>

			<div class="uppercase font-17 font-allerRg grey-text margin-top-20">waist</div>

			<!-- waist -->
			<div class="flex-row flex-wrap margin-top-10" id="waist">
				<?php foreach($sizeDisplay as $sizeDisplay): ?>
				<div class="col-2 col-l-1 cursor-pointer">
					<div class="border-all-1 center-text padding-all-10 deep-grey-white-text-hover">
						<?=$sizeDisplay;?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

			<div class="uppercase font-17 font-allerRg grey-text margin-top-20">length</div>

			<!-- length -->
			<div class="flex-row flex-wrap margin-top-10" id="length">
				<?php foreach($lengthDisplay as $lengthDisplay): ?>
				<div class="col-2 col-l-1 cursor-pointer">
					<div class="border-all-1 center-text padding-all-10 deep-grey-white-text-hover">
						<?=trim($lengthDisplay); ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

			<div class="margin-top-10"></div>

			<div class="uppercase font-17 font-allerRg grey-text margin-top-20">price</div>

			<!-- price -->
			<div class="margin-top-10 row" id="price">
				<div class="col-12 col-s-6 col-m-6 col-l-3 flex-row">
					<input type="checkbox" name="" value="0-50">
					<div class="capitalize font-allerRg padding-left-10">$0-$50</div>
				</div>
				<div class="col-12 col-s-6 col-m-6 col-l-3 flex-row">
					<input type="checkbox" name="" value="50-75">
					<div class="capitalize font-allerRg padding-left-10">$50-$75</div>
				</div>
				<div class="col-12 col-s-6 col-m-6 col-l-3 flex-row">
					<input type="checkbox" name="" value="75-100">
					<div class="capitalize font-allerRg padding-left-10">$75-$100</div>
				</div>
				<div class="col-12 col-s-6 col-m-6 col-l-3 flex-row">
					<input type="checkbox" name="" value="100">
					<div class="capitalize font-allerRg padding-left-10">$100+</div>
				</div>
			</div>

		</div>

		<script type="text/javascript">

			function price(){
				let price = document.querySelectorAll('#price .flex-row input[type=checkbox]');
				let count = price.length;

				for(let i=0; i<count; i++){
					price[i].addEventListener('change', e=>{
						if(price[i].checked){
							let value = price[i].value;
							// fetch
						fetch('<?=url_location;?>api/product/fetch_ajax_price.php?price='+value)
						.then(response=>response.json())
						.then(data=>{
							let output = '';
							let count = data.length;
							if(count>0){
							for(j=0; j<count; j++){
								output += `<div class="col-4 col-s-6 col-m-6">
							<div class="border-all-hover item">
							<div class="relative flex-column justify-content-center align-items-center padding-all-10 padding-s-all-2">
							<a href="view.php?id=${data[j].id}" target="blank">
							<div class="img-container-100">
							<img src="${data[j].image}" />
							</div>
							</a>
							<div class="font-allerRg capitalize font-s-12">
							${data[j].title}
							</div>
							<div class="font-allerRg font-s-12">${data[j].price}</div>
							<div class="absolute cursor-pointer white-bg quick-view uppercase">
							<a href="view.php?id=${data[j].id}" target="blank">quick view</a>
							</div>
							</div>
							</div>
							</div>`;
							}
							}//end of if
							else{
								output += `<div class="font-allerRg center-text">No such featured product</div>`;
							}	
							//console.log(count);
							document.querySelector('#row').innerHTML = output;
						})
						.catch(error=>console.log(error));
						}else{
							// fetch
						fetch('<?=url_location;?>api/product/fetch_ajax.php?')
						.then(response=>response.json())
						.then(data=>{
							let output = '';
							let count = data.length;
							for(j=0; j<count; j++){
								output += `<div class="col-4 col-s-6 col-m-6">
							<div class="border-all-hover item">
							<div class="relative flex-column justify-content-center align-items-center padding-all-10 padding-s-all-2">
							<a href="view.php?id=${data[j].id}" target="blank">
							<div class="img-container-100">
							<img src="${data[j].image}" />
							</div>
							</a>
							<div class="font-allerRg capitalize font-s-12">
							${data[j].title}
							</div>
							<div class="font-allerRg font-s-12">${data[j].price}</div>
							<div class="absolute cursor-pointer white-bg quick-view uppercase">
							<a href="view.php?id=${data[j].id}" target="blank">quick view</a>
							</div>
							</div>
							</div>
							</div>`;
							}
							//console.log(count);
							document.querySelector('#row').innerHTML = output;
						})
						.catch(error=>console.log(error));
						}
					});
				}
			}
			price();

			function waist(){
				let waist = document.querySelectorAll('#waist div div');
				let count = waist.length;

				for(let i=0; i<count; i++){
					waist[i].addEventListener('click', e=>{
						let value = waist[i].innerHTML;
						// fetch
						fetch('<?=url_location;?>api/product/fetch_ajax_size.php?size='+value)
						.then(response=>response.json())
						.then(data=>{
							let output = '';
							let count = data.length;
							if(count>0){
							for(j=0; j<count; j++){
								output += `<div class="col-4 col-s-6 col-m-6">
							<div class="border-all-hover item">
							<div class="relative flex-column justify-content-center align-items-center padding-all-10 padding-s-all-2">
							<a href="view.php?id=${data[j].id}" target="blank">
							<div class="img-container-100">
							<img src="${data[j].image}" />
							</div>
							</a>
							<div class="font-allerRg capitalize font-s-12">
							${data[j].title}
							</div>
							<div class="font-allerRg font-s-12">${data[j].price}</div>
							<div class="absolute cursor-pointer white-bg quick-view uppercase">
							<a href="view.php?id=${data[j].id}" target="blank">quick view</a>
							</div>
							</div>
							</div>
							</div>`;
							}
							}//end of if
							else{
								output += `<div class="font-allerRg center-text">No such featured product</div>`;
							}
							//console.log(count);
							document.querySelector('#row').innerHTML = output;
						})
						.catch(error=>console.log(error));
					});
				}
			}
			waist();

			function jeansLength(){
				let jeansLength = document.querySelectorAll('#length div div');
				let count = jeansLength.length;

				for(let i=0; i<count; i++){
					jeansLength[i].addEventListener('click', e=>{
						let value = jeansLength[i].innerHTML;
						// fetch
						fetch('<?=url_location;?>api/product/fetch_ajax_length.php?length='+value)
						.then(response=>response.json())
						.then(data=>{
							let output = '';
							let count = data.length;
							if(count>0){
							for(j=0; j<count; j++){
								output += `<div class="col-4 col-s-6 col-m-6">
							<div class="border-all-hover item">
							<div class="relative flex-column justify-content-center align-items-center padding-all-10 padding-s-all-2">
							<a href="view.php?id=${data[j].id}" target="blank">
							<div class="img-container-100">
							<img src="${data[j].image}" />
							</div>
							</a>
							<div class="font-allerRg capitalize font-s-12">
							${data[j].title}
							</div>
							<div class="font-allerRg font-s-12">${data[j].price}</div>
							<div class="absolute cursor-pointer white-bg quick-view uppercase">
							<a href="view.php?id=${data[j].id}" target="blank">quick view</a>
							</div>
							</div>
							</div>
							</div>`;
							}
							}//end of if
							else{
								output += `<div class="font-allerRg center-text">No such featured product</div>`;
							}
							//console.log(data);
							document.querySelector('#row').innerHTML = output;
						})
						.catch(error=>console.log(error));
					});
				}
			}
			jeansLength();
			//alert(count);
		</script>

		<!-- right -->
		<div id="content" class="col-9 col-s-12 col-m-12 col-l-12 padding-all-10 padding-s-all-2">
			<!-- mini banner -->
			<div class="width-auto height-45 height-s-10 height-m-20 banner overflow-hidden">
				<img src="<?=url_location;?>images/men/m.png" />
				<div class="width-auto height-auto flex-column justify-content-center align-items-center">
					<div class="uppercase white-text font-40 font-s-20 font-m-30 font-allerBd">the taper jeans</div>
					<div class="white-text font-allerRg font-s-12">Because the right fit is everything</div>
				</div>
			</div>

			<!-- break -->
			<div class="width-100 height-10"></div>

			<div class="row" id="row">
				<?php if(isset($_GET['cat'])){ 
					$catId = $_GET['cat'];
					//Get products by category
					$catData = json_decode(file_get_contents(url_location.'api/product/fetch_by_cat.php?id='.$catId),true);
					//echo json_encode($catData);
				?>
				<!-- product by category -->
				

				<?php if(!empty($catData)){ ?> <!-- Check if category array is not empty -->
				<?php  foreach($catData as $catData): ?>
				<div class="col-4 col-s-6 col-m-6"> <!-- height-80 height-s-50 -->
					<div class="border-all-hover item"> <!-- width-auto height-auto -->
						<div class="relative flex-column justify-content-center align-items-center padding-all-10 padding-s-all-2"> <!-- width-auto height-auto -->
							<a href="view.php?id=<?=$catData['id'];?>" target="blank">
							<div class="img-container-100"> <!-- width-auto width-s-100 height-70 height-s-40 -->
								<img src="<?=$catData['image'];?>" />
							</div>
							</a>
							<div class="font-allerRg capitalize font-s-12">
								<?=$catData['title'];?>		
							</div>
							<div class="font-allerRg font-s-12">$<?=$catData['price'];?></div>

							<div class="absolute cursor-pointer white-bg quick-view uppercase">
							<a href="<?=url_location;?>view.php?id=<?=$catData['id'];?>">Quick View</a>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
				<?php }else{ ?> <!-- end of check -->
					<div class="col-12 center-text font-allerRg capitalize">
						Product is currently unavailable! You can order unavailable products from us if you please! <span class="blue-text">Happy shopping!!!</span>
					</div>
				<?php } ?>

				<!-- End of product by category -->

				<?php }elseif(isset($_GET['search'])){ 
					$search = $_GET['search'];
					$search = trim($search);
					$search = strtolower($search);

					$searchResult = array();

					//Get searched product
					$searchData = json_decode(file_get_contents(url_location.'api/product/fetch_ajax.php'),true);
					foreach ($searchData as $searchData) {
						if(strtolower($searchData['title']) == $search){
							array_push($searchResult, $searchData);
						}
					}
				?>
					<?php if(!empty($searchResult)){ ?>
						<?php foreach($searchResult as $searchResult): ?>
							<div class="col-4 col-s-6 col-m-6"> <!-- height-80 height-s-50 -->
								<div class="border-all-hover item"> <!-- width-auto height-auto -->
									<div class="relative flex-column justify-content-center align-items-center padding-all-10 padding-s-all-2"> <!-- width-auto height-auto -->
										<a href="view.php?id=<?=$searchResult['id'];?>" target="blank">
										<div class="img-container-100"> <!-- width-auto width-s-100 height-70 height-s-40 -->
											<img src="<?=$searchResult['image'];?>" />
										</div>
										</a>
										<div class="font-allerRg capitalize font-s-12">
											<?=$searchResult['title'];?>		
										</div>
										<div class="font-allerRg font-s-12">$<?=$searchResult['price'];?></div>

										<div class="absolute cursor-pointer white-bg quick-view uppercase">
										<a href="<?=url_location;?>view.php?id=<?=$searchResult['id'];?>">Quick View</a>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php }else{ ?>
					<div class="font-allerRg capitalize center-text">
						Product is currently unavailable. Please check our other products. 
						<span class="blue-text">Happy shopping!!!</span>
					</div>
					
					<?php } ?>

				<?php }else{ ?>

				<?php  foreach($product as $product): ?>
				<div class="col-4 col-s-6 col-m-6"> <!-- height-80 height-s-50 -->
					<div class="border-all-hover item"> <!-- width-auto height-auto -->
						<div class="relative flex-column justify-content-center align-items-center padding-all-10 padding-s-all-2"> <!-- width-auto height-auto -->
							<a href="view.php?id=<?=$product['id'];?>" target="blank">
							<div class="img-container-100"> <!-- width-auto width-s-100 height-70 height-s-40 -->
								<img src="<?=$product['image'];?>" />
							</div>
							</a>
							<div class="font-allerRg capitalize font-s-12">
								<?=$product['title'];?>		
							</div>
							<div class="font-allerRg font-s-12">$<?=$product['price'];?></div>

							<div class="absolute cursor-pointer white-bg quick-view uppercase">
							<a href="<?=url_location;?>view.php?id=<?=$product['id'];?>">Quick View</a>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>

				<?php } ?> <!-- End of else -->
			</div>
		</div>
	</div>
</div>


<!-- end of isset of cat -->
<?php  
	// }
	//else display this down
	// else{}
?>

<!-- side nav -->
<?php include "includes/side_nav.php"; ?>

<!-- footer -->
<?php include "includes/footer.php"; ?>

<!-- script -->
<?php include "includes/script.php"; ?>

<!-- tail -->
<?php include "includes/tail.php"; ?>

<?php }else{header('Location: index.php');} ?>