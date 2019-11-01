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
	if(isset($_POST['sign_in_token'])){
		$token = $_POST['sign_in_token'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		if($token == $_SESSION['sign_in_token']){
			//prepare email and password for db check 
			$customer->email = $email;
			$customer->password = $password;

			if($customer->verify()){
				$_SESSION['customer_email'] = $email;
				$cust_data = json_decode(file_get_contents(url_location.'api/customer_account/fetch.php'),true);
				foreach ($cust_data as $cust_data) {
					if($cust_data['email'] == $_SESSION['customer_email']){
						$_SESSION['details']['id'] = $cust_data['id'];
						$_SESSION['details']['first_name'] = $cust_data['first_name'];
						$_SESSION['details']['last_name'] = $cust_data['last_name'];
						$_SESSION['details']['address'] = $cust_data['address'];
						$_SESSION['details']['town'] = $cust_data['town'];
						$_SESSION['details']['state'] = $cust_data['state'];
						$_SESSION['details']['postal_code'] = $cust_data['postal_code'];
						$_SESSION['details']['country'] = $cust_data['country'];
						$_SESSION['details']['email'] = $cust_data['email'];
						$_SESSION['details']['number'] = $cust_data['number'];
					}
				}
				header('Location: '.url_location.'my_account/?msg=Welcome');
			}else{
				$msg = 'Mismatched fields';
				header('Location: '.$url."?msg=".$msg);
			}
		}
	}else{
		die();
	}
}else{
	die();
}


?>