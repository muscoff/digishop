<?php  

class CustomerLogin{
	private $table = 'customer_login';
	private $DBH;
	public $id;
	public $email;
	public $password;
	public $created_at;

	public function __construct($db){
		$this->DBH = $db;
	}

	public function read_single(){
		// Query
		$query = "SELECT * FROM ".$this->table." WHERE `email`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->email = htmlspecialchars(strip_tags($this->email));

		// Execute
		$STH->execute([$this->email]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function create(){
		// query
		$query = "INSERT INTO ".$this->table." (`email`, `password`) VALUES (:email, :password)";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->password = htmlspecialchars(strip_tags($this->password));

		// Hash password
		$this->password = password_hash($this->password, PASSWORD_DEFAULT);

		// BindParams
		$STH->bindParam(':email', $this->email);
		$STH->bindParam(':password', $this->password);

		// Execute
		$STH->execute();

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function verify(){
		// query
		$query = "SELECT * FROM ".$this->table." WHERE `email`=?";

		// Prepare
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->password = htmlspecialchars(strip_tags($this->password));

		// Execute
		$STH->execute([$this->email]);

		if($STH->rowCount()){
			$data = $STH->fetch(PDO::FETCH_OBJ);
			$hashpassword = $data->password;

			if(password_verify($this->password,$hashpassword)){
				return true;
			}else{
				return false;
			}
		}
	}
}

?>