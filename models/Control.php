<?php  

class Control{
	private $table = 'control_settings';
	private $DBH;
	public $id;
	public $first_sec;
	public $second_sec;
	public $third_sec;
	public $fourth_sec;
	public $fifth_sec;
	public $sixth_sec;
	public $seventh_sec;
	public $logo;
	public $created_at;

	public function __construct($db){
		$this->DBH = $db;
	}

	public function fetch(){
		// query statement
		$query = "SELECT * FROM ".$this->table;

		// prepare statement
		$STH = $this->DBH->prepare($query);

		// execute
		$STH->execute();

		if($STH->rowCount()){
			$data = $STH->fetch(PDO::FETCH_OBJ);
			return array('id'=>$data->id, 'first_sec'=>(int)$data->first_sec, 'second_sec'=>(int)$data->second_sec, 'third_sec'=>(int)$data->third_sec, 'fourth_sec'=>(int)$data->fourth_sec, 'fifth_sec'=>(int)$data->fifth_sec, 'sixth_sec'=>(int)$data->sixth_sec, 'seventh_sec'=>(int)$data->seventh_sec, 'logo'=>$data->logo, 'created_at'=>$data->created_at);
		}else{
			die('No data to fetch');
		}
	}

	public function create(){
		// query statement
		$query = "INSERT INTO ".$this->table." (`logo`) VALUES (?)";

		// prepare statement
		$STH = $this->DBH->prepare($query);

		// execute
		$STH->execute([$this->logo]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function update_logo(){
		// query statement
		$query = "UPDATE ".$this->table." SET `logo`=? WHERE `id`=?";

		// prepare statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->id = htmlspecialchars(strip_tags($this->id));

		// execute
		$STH->execute([$this->logo, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function update_one(){
		// query statement
		$query = "UPDATE ".$this->table." SET `first_sec`=? WHERE `id`=?";

		// prepare statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->first_sec = htmlspecialchars(strip_tags($this->first_sec));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// execute
		$STH->execute([$this->first_sec, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function update_two(){
		// query statement
		$query = "UPDATE ".$this->table." SET `second_sec`=? WHERE `id`=?";

		// prepare statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->second_sec = htmlspecialchars(strip_tags($this->second_sec));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// execute
		$STH->execute([$this->second_sec, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function update_three(){
		// query statement
		$query = "UPDATE ".$this->table." SET `third_sec`=? WHERE `id`=?";

		// prepare statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->third_sec = htmlspecialchars(strip_tags($this->third_sec));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// execute
		$STH->execute([$this->third_sec, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function update_four(){
		// query statement
		$query = "UPDATE ".$this->table." SET `fourth_sec`=? WHERE `id`=?";

		// prepare statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->fourth_sec = htmlspecialchars(strip_tags($this->fourth_sec));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// execute
		$STH->execute([$this->fourth_sec, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function update_five(){
		// query statement
		$query = "UPDATE ".$this->table." SET `fifth_sec`=? WHERE `id`=?";

		// prepare statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->fifth_sec = htmlspecialchars(strip_tags($this->fifth_sec));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// execute
		$STH->execute([$this->fifth_sec, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function update_six(){
		// query statement
		$query = "UPDATE ".$this->table." SET `sixth_sec`=? WHERE `id`=?";

		// prepare statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->sixth_sec = htmlspecialchars(strip_tags($this->sixth_sec));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// execute
		$STH->execute([$this->sixth_sec, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function update_seven(){
		// query statement
		$query = "UPDATE ".$this->table." SET `seventh_sec`=? WHERE `id`=?";

		// prepare statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->seventh_sec = htmlspecialchars(strip_tags($this->seventh_sec));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// execute
		$STH->execute([$this->seventh_sec, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}
}


?>