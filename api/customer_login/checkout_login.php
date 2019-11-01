<?php  
session_start();

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/CustomerLogin.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

// Initialize db
$DBH = new DB();
$db = $DBH->connect();

// Initialize Customer Login
$customer = new CustomerLogin($db);

// get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

// Get Host 
$HOST = $_SERVER['HTTP_HOST'];
$referer = null;

if(isset($_SERVER['HTTP_REFERER'])){
	$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
}

if($HOST == $referer){
	if(isset($_POST['checkout_login_token'])){
		$token = $_POST['checkout_login_token'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		if($token == $_SESSION['checkout_login_token']){
			//Initailize data for db check
			$customer->email = $email;
			$customer->password = $password;

			// verify
			if($customer->verify()){
				$_SESSION['customer_email'] = $email;

				// Get info to set session details
				$userData = json_decode(file_get_contents(url_location.'api/customer_account/fetch.php'),true);
				foreach ($userData as $userData) {
					if($userData['email'] == $email){
						$_SESSION['details']['id'] = $userData['id'];
						$_SESSION['details']['first_name'] = $userData['first_name'];
						$_SESSION['details']['last_name'] = $userData['last_name'];
						$_SESSION['details']['address'] = $userData['address'];
						$_SESSION['details']['town'] = $userData['town'];
						$_SESSION['details']['state'] = $userData['state'];
						$_SESSION['details']['postal_code'] = $userData['postal_code'];
						$_SESSION['details']['email'] = $userData['email'];
						$_SESSION['details']['number'] = $userData['number'];
					}
				}

				$arr = array();

				foreach ($_SESSION['cart'] as $cart) {
					array_push($arr, $cart['total']);
				}
				$sum = array_sum($arr);
				$_SESSION['final'] = $sum + $_SESSION['shipping'];

				if(!empty($_SESSION['details'])){
					header('Location: '.url_location.'checkout/pay.php');
				}else{
					header('Location: '.url_location.'my_account/');
				}
			}else{
				$msg = 'Mismatched fields';
				header('Location: '.$url."?msg=".$msg);
			}
		}else{
			die();
		}
	}
}else{
	die();
}

?>