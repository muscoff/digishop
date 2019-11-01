<?php  
session_start();
session_regenerate_id(true);

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/CartInfo.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/CustomerAccount.php";

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){

// initialize db
$DBH = new DB();
$db = $DBH->connect();

// initialize cartinfo
$cart = new CartInfo($db);

// initialize Customer Account
$customer = new CustomerAccount($db);
?>

<?php include 'includes/head.php'; ?>

<?php include 'includes/nav.php'; ?>

<!-- break -->
<div class="width-100 height-10"></div>
<div class="center-text capitalize font-allerBd">Order placement</div>

<!-- break -->
<div class="width-100 height-5"></div>

<?php  
	if(isset($_GET['shipping'])){
		$email = $_GET['shipping'];

		// initialize email for customer account
		$customer->email = $email;

		$CustomerDetails = $customer->fetch_single();

?>

<div class="width-50 width-s-100 width-m-90 margin-auto">
	<div class="row">
		<div class="col-6 col-s-12 padding-all-10"><input type="text" class="transparent border-all-1" readonly value="<?=$CustomerDetails['first_name'];?>"></div>

		<div class="col-6 col-s-12 padding-all-10"><input type="text" class="transparent border-all-1" readonly value="<?=$CustomerDetails['last_name'];?>"></div>

		<div class="col-12 col-s-12 padding-all-10"><input type="text" class="transparent border-all-1" readonly value="<?=$CustomerDetails['address'];?>"></div>

		<div class="col-12 col-s-12 padding-all-10"><input type="text" class="transparent border-all-1" readonly value="<?=$CustomerDetails['address'];?>"></div>

		<div class="col-4 col-s-12 padding-all-10"><input type="text" class="transparent border-all-1" readonly value="<?=$CustomerDetails['town'];?>"></div>

		<div class="col-4 col-s-12 padding-all-10"><input type="text" class="transparent border-all-1" readonly value="<?=$CustomerDetails['state'];?>"></div>

		<div class="col-4 col-s-12 padding-all-10"><input type="text" class="transparent border-all-1" readonly value="<?=$CustomerDetails['postal_code'];?>"></div>

		<div class="col-6 col-s-12 padding-all-10"><input type="text" class="transparent border-all-1" readonly value="<?=$CustomerDetails['country'];?>"></div>

		<div class="col-6 col-s-12 padding-all-10"><input type="text" class="transparent border-all-1" readonly value="<?=$CustomerDetails['email'];?>"></div>

		<div class="col-12 col-s-12 padding-all-10"><input type="text" class="transparent border-all-1" readonly value="<?=$CustomerDetails['number'];?>"></div>
	</div>
</div>

<?php  
	}elseif(isset($_GET['id'])){
		$id = $_GET['id'];
		$email = $_GET['email'];

		function splitColumn($arg){
			// explode argument to get the last bit
			$explodeArg = explode(':', $arg);
			return $explodeArg[1];
		}

		$UserCart = array();

		// initialize for db fetch
		$cart->id = $id;
		$cart->email = $email;

		$single = $cart->fetch_single();
		$singleInfo = $single['cart_items'];

		// Explode to get individual cart info
		$explodeCart = explode('|', $singleInfo);
		foreach ($explodeCart as $explodeCart) {
			$explode = explode(',', $explodeCart);
			$putId = splitColumn($explode[0]);
			$putName = splitColumn($explode[1]);
			$putQuantity = splitColumn($explode[2]);
			$putSize = splitColumn($explode[3]);
			$putLength = splitColumn($explode[4]);
			$putPrice = splitColumn($explode[5]);
			$putImage = ltrim($explode[6], 'image:');

			$arrayPush = array('id'=>$putId, 'name'=>$putName, 'quantity'=>$putQuantity, 'size'=>$putSize, 'length'=>$putLength, 'price'=>$putPrice, 'image'=>$putImage);
			array_push($UserCart, $arrayPush);
		}

		//echo json_encode($UserCart);
?>

<div class="width-40 width-s-100 width-m-90 margin-auto">
	<a href="<?=url_location;?>admin/order.php?shipping=<?=$email;?>">
		<div class="font-allerRg padding-all-10 blue-text">Click To View Shipping info</div>
	</a>
	<div class="row">
		<?php foreach($UserCart as $userCart): ?>
		<div class="col-3 col-s-6 col-m-6 padding-all-10">
			<div class="img-container-100">
				<img src="<?=$userCart['image'];?>">
			</div>
		</div>
		<div class="col-9 col-s-6 col-m-6 padding-all-10">
			<div class="font-allerRg">
				<span class="font-allerBd capitalize padding-right-10">product name :</span><?=$userCart['name'];?>
			</div>
			<div class="font-allerRg">
				<span class="font-allerBd capitalize padding-right-10">quantity :</span><?=$userCart['quantity'];?>
			</div>
			<div class="font-allerRg">
				<span class="font-allerBd capitalize padding-right-10">size :</span><?=$userCart['size'];?>
			</div>
			<div class="font-allerRg">
				<span class="font-allerBd capitalize padding-right-10">length :</span><?=$userCart['length'];?>
			</div>
			<div class="font-allerRg">
				<span class="font-allerBd capitalize padding-right-10">price :</span><?=$userCart['price'];?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>

<?php }else{ ?>

<div class="width-50 width-s-100 width-m-90 margin-auto">
	<table class="table bordered">
		<thead>
			<tr class="capitalize font-allerBd">
				<th>customer_id</th>
				<th>email</th>
				<th>date</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php  

			$cartData = $cart->fetch();

			if(empty($cartData)){
			?>
			<tr>
				<td colspan="4">No order yet!</td>
			</tr>
			<?php }else{ ?>
				<?php foreach($cartData as $cartData): ?>
				<tr class="font-allerRg">
					<td><?=$cartData['customer_id'];?></td>
					<td><?=$cartData['email'];?></td>
					<td><?=$cartData['created_at'];?></td>
					<td>
						<a href="<?=url_location;?>admin/order.php?id=<?=$cartData['id'];?>&email=<?=$cartData['email'];?>" class="red-hover">
							<span class="capitalize">view</span>
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php } ?>
		</tbody>
	</table>
</div>

<?php } ?>

<!-- break -->
<div class="width-100 height-10"></div>

<?php include 'includes/footer.php'; ?>

<?php }else{header('Location: ../admin/');} ?>