<?php  

class CustomerAccount{
	private $table = 'customer_account';
	private $DBH;
	public $id;
	public $first_name;
	public $last_name;
	public $address;
	public $town;
	public $state;
	public $postal_code;
	public $country;
	public $email;
	public $number;
	public $created_at;

	public function __construct($db){
		$this->DBH = $db;
	}

	public function fetch(){
		// Query
		$query = "SELECT * FROM ".$this->table;

		// Prepare
		$STH = $this->DBH->prepare($query);

		// Execute
		$STH->execute();

		$data = array();

		if($STH->rowCount()){
			$data = $STH->fetchAll(PDO::FETCH_OBJ);
			// while($row = $STH->fetch(PDO::FETCH_OBJ)){
			// 	$arr = array('id'=>$row->id, 'first_name'=>$row->first_name, 'last_name'=>$row->last_name, 'address'=>$row->address, 'town'=>$row->town, 'state'=>$row->state, 'postal_code'=>$row->postal_code, 'country'=>$row->country, 'email'=>$row->email, 'number'=>$row->number, 'created_at'=>$row->created_at);
			// 	array_push($data, $arr);
			// }
			return $data;
		}else{
			die('Failed...');
		}
	}

	public function fetch_single(){
		// Query
		$query = "SELECT * FROM ".$this->table." WHERE `email`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->email = htmlspecialchars(strip_tags($this->email));

		// Execute
		$STH->execute([$this->email]);

		if($STH->rowCount()){
			$data = $STH->fetch(PDO::FETCH_OBJ);
			return array(
				'id' => $data->id, 
				'first_name' => $data->first_name, 
				'last_name' => $data->last_name,
				'address' => $data->address,
				'town' => $data->town,
				'state' => $data->state,
				'postal_code' => $data->postal_code,
				'country' => $data->country,
				'email' => $data->email,
				'number' => $data->number,
				'created_at' => $data->created_at
			);
		}else{
			die('Failed to fetch...');
		}
	}

	public function create(){
		// query
		$query = "INSERT INTO ".$this->table." (`first_name`, `last_name`, `address`, `town`, `state`, `postal_code`, `country`, `email`, `number`) VALUES (:firstname, :lastname, :address, :town, :state, :postalcode, :country, :email, :number)";
		// Prepare
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->first_name = htmlspecialchars(strip_tags($this->first_name));
		$this->last_name = htmlspecialchars(strip_tags($this->last_name));
		$this->address = htmlspecialchars(strip_tags($this->address));
		$this->town = htmlspecialchars(strip_tags($this->town));
		$this->state = htmlspecialchars(strip_tags($this->state));
		$this->postal_code = htmlspecialchars(strip_tags($this->postal_code));
		$this->country = htmlspecialchars(strip_tags($this->country));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->number = htmlspecialchars(strip_tags($this->number));


		// BindParam
		$STH->bindParam(':firstname', $this->first_name);
		$STH->bindParam(':lastname', $this->last_name);
		$STH->bindParam(':address', $this->address);
		$STH->bindParam(':town', $this->town);
		$STH->bindParam(':state', $this->state);
		$STH->bindParam(':postalcode', $this->postal_code);
		$STH->bindParam(':country', $this->country);
		$STH->bindParam(':email', $this->email);
		$STH->bindParam(':number', $this->number);

		// Execute
		$STH->execute();

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function edit(){
		// query
		$query = "UPDATE ".$this->table." SET `first_name`=?, `last_name`=?, `address`=?, `town`=?, `state`=?, `postal_code`=?, `country`=?, `email`=?, `number`=? WHERE `id`=?";

		// Prepare Query
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->first_name = htmlspecialchars(strip_tags($this->first_name));
		$this->last_name = htmlspecialchars(strip_tags($this->last_name));
		$this->address = htmlspecialchars(strip_tags($this->address));
		$this->town = htmlspecialchars(strip_tags($this->town));
		$this->state = htmlspecialchars(strip_tags($this->state));
		$this->postal_code = htmlspecialchars(strip_tags($this->postal_code));
		$this->country = htmlspecialchars(strip_tags($this->country));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->number = htmlspecialchars(strip_tags($this->number));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->first_name, $this->last_name, $this->address, $this->town, $this->state, $this->postal_code, $this->country, $this->email, $this->number, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}
}

?>