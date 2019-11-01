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

<!-- title -->
<div class="width-100 height-10 flex-column justify-content-center align-items-center font-allerBd font-20 uppercase deep-grey-text">
	shopping bag	
</div>

<div class="row">
	<div class="col-8 col-s-12 col-m-12 col-l-12 padding-all-10">
		<div class="row" id="item-list"></div>
	</div>

	<!-- check out -->
	<div class="col-4 col-s-12 col-m-12 col-l-12 padding-all-10" id="checkout">
		<a href="<?=url_location;?>checkout/">
		<div class="width-auto height-10 flex-column justify-content-center align-items-center uppercase red-bg white-text font-allerBd font-20 btn cursor-pointer">checkout</div>
		</a>

		<!-- promo code-->
		<div class="width-auto height-20 padding-all-10 margin-top-10 border-all-1">
			<div class="uppercase font-allerBd font-20">promo code</div>
			<div class="flex-row">
				<div class="width-60 width-s-50 padding-all-10"><input type="text" name=""></div>
				<div class="width-40 width-s-50 padding-all-10">
					<div class="btn uppercase font-allerBd input cursor-pointer">apply now</div>
				</div>
			</div>
		</div>

		<div class="padding-all-10 font-allerBd light-grey-bg border-all-1">
			<div class="flex-row">
				<div class="col-9"><div class="capitalize">subtotal</div></div>
				<div class="col-3"><div class="capitalize"><span id="subtotal"></span></div></div>
			</div>
			<div class="flex-row">
				<div class="col-6"><div class="capitalize">shipping</div></div>
				<div class="col-6"><div class="capitalize">Proceed to see options</div></div>
			</div>
		</div>

		<div class="padding-all-10 font-allerBd border-all-1">
			<div class="flex-row">
				<div class="col-9"><div class="capitalize">total</div></div>
				<div class="col-3"><div class="capitalize"><span id="total"></span></div></div>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
	function getCartItems(){
		fetch('<?=url_location;?>cart.php')
		.then(response=>response.json())
		.then(result=>{
			let output = '';
			if(result.length == 0){
				output += `<div class="font-allerRg center-text blue-text">Your cart is empty. Please purchase some items. Happy shopping!!</div>`;
				document.querySelector('#checkout').classList.add('display-none');
				document.querySelector('#item-list').innerHTML = output;
			}else{
			for(j in result)
				{
				output += `
					<div class="col-3 col-s-6 col-m-6 padding-all-10">
						<div class="img-container-100">
							<img src="${result[j].image}" />
						</div>
					</div>
					<div class="col-9 col-s-6 col-m-6">
						<div class="row">
							<div class="col-6 col-s-12 col-m-12 padding-all-10 font-allerRg">
								<div class="capitalize font-20 font-s-15">${result[j].name}</div>
								<div class="font-20 font-s-15">$<span>${result[j].price}</span></div>
								<div class="margin-top-10 deep-grey-text font-s-12">Size: <span>${result[j].size}</span></div>
								<div class="margin-top-10 deep-grey-text capitalize font-s-12">subtotal: <span class="subtotal">${result[j].total}</span></div>
							</div>
							<div class="col-6 col-s-12 col-m-12">
								<div><input oninput="changeQty(${j})" class="input quantity" type="text" name="" value="${result[j].quantity}"></div>
								<div onclick="removeItem(${j})" class="deep-grey-text font-allerRg capitalize margin-top-10 right-text cursor-pointer">
									remove
								</div>
								<div class="info" data-id="${result[j].id}" data-size="${result[j].size}" data-quantity="" data-length="${result[j].len}"></div>
							</div>
						</div>
					</div>`;
				}
				document.querySelector('#item-list').innerHTML = output;
			}
		})
		.catch(error=>console.log(error));
	}
	getCartItems();

	//Get price
	function getPrice(){
		let subtotal = document.querySelector('#subtotal');
		let total = document.querySelector('#total');
		fetch('<?=url_location;?>cart.php?price')
		.then(response=>response.json())
		.then(response=>{subtotal.innerHTML = response.price; total.innerHTML = response.price;})
		.catch(error=>console.log(error));
		setTimeout(getPrice, 600);
	}
	getPrice();

	function changeQty(index){
		let cartInfo = document.querySelectorAll('#item-list .info');
		let len = cartInfo[index].getAttribute('data-length');
		let id = cartInfo[index].getAttribute('data-id');
		let size = cartInfo[index].getAttribute('data-size');
		let quantities = document.querySelectorAll('#item-list .quantity');
		let quantity = quantities[index].value;
		
		if(quantity != ''){
			let formData = new FormData();
			formData.append('id', id);
			formData.append('size', size);
			formData.append('length', len);
			formData.append('quantity', quantity);

			fetch('<?=url_location;?>add_ajax.php', {
				method: 'POST',
				body: formData
			})
			.then(response=>response.json())
			.then(response=>{
				if(response.msg){
					// console.log(response);
					//getCartItems();
					fetch('<?=url_location;?>cart.php')
					.then(response=>response.json())
					.then(data=>{
						let subT = data[index].total;
						console.log(subT);
						document.querySelectorAll('.subtotal')[index].innerHTML = subT;
					})
					.catch(error=>console.log(error));
					//let subtotal = document.querySelectorAll('.subtotal');
				}
			})
			.catch(error=>console.log(error));
		}
	}

	function removeItem(index){
		let key = index;
		fetch('<?=url_location;?>remove_item.php?key='+key)
		.then(response=>response.json())
		.then(response=>{
			if(response.msg){
				getCartItems();
			}
		})
		.catch(error=>console.log(error));
	}	
</script>

<!-- side nav -->
<?php include "includes/side_nav.php"; ?>

<!-- footer -->
<?php include "includes/footer.php"; ?>

<!-- JS script -->
<?php include "includes/script.php"; ?>

<!-- tail -->
<?php include "includes/tail.php"; ?>

<?php }else{header('Location: index.php');} ?>