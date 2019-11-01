<?php  

class User{
	private $table = 'admin_login';
	private $DBH;
	public $id;
	public $password;
	public $created_at;

	public function __construct($db){
		$this->DBH = $db;
	}

	public function create(){
		// Query Statement
		$query = "INSERT INTO ".$this->table." (`password`) VALUES (?)";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean data
		$this->password = htmlspecialchars(strip_tags($this->password));

		// Execute
		$STH->execute([$this->password]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function verify(){
		// query statement
		$query = "SELECT * FROM ".$this->table;

		//Prepare statement
		$STH = $this->DBH->prepare($query);

		//Execute
		$STH->execute();

		if($STH->rowCount()){
			$data = $STH->fetch(PDO::FETCH_OBJ);
			$pass = $data->password;
			if(password_verify($this->password,$pass)){
				return true;
			}else{
				return false;
			}
		}
	}
}

?>