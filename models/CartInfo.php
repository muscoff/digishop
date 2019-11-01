<?php  

class CartInfo{
	private $table = 'cart';
	private $DBH;
	public $id;
	public $customer_id;
	public $email;
	public $cart_items;
	public $created_at;

	public function __construct($db){
		$this->DBH = $db;
	}

	public function fetch(){
		// Query Statement
		$query = "SELECT * FROM ".$this->table;

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Execute
		$STH->execute();

		$data = array();

		if($STH->rowCount()){
			while($row = $STH->fetch(PDO::FETCH_OBJ)){
				$item = array(
					'id'=> $row->id,
					'customer_id'=> $row->customer_id,
					'email'=>$row->email,
					'cart_items'=>$row->cart_items,
					'created_at'=>$row->created_at
				);
				array_push($data, $item);
			}
			return $data;
		}else{
			die('...Empty...');
		}
	}

	public function fetch_single(){
		// query Statement
		$query = "SELECT * FROM ".$this->table." WHERE `id`=? AND `email`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// clean data
		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->email = htmlspecialchars(strip_tags($this->email));

		// Execute
		$STH->execute([$this->id, $this->email]);

		if($STH->rowCount()){
			$data = $STH->fetch(PDO::FETCH_OBJ);
			return array('id'=>$data->id, 'email'=>$data->email, 'customer_id'=>$data->customer_id, 'cart_items'=>$data->cart_items);
		}else{
			die('...Failed to get single info...');
		}
	}

	public function create(){
		// query
		$query = "INSERT INTO ".$this->table." (`customer_id`, `email`, `cart_items`) VALUES (:customer_id, :email, :cart_items)";

		// Prepare 
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->cart_items = strip_tags($this->cart_items);

		// BindParams
		$STH->bindParam(':customer_id', $this->customer_id);
		$STH->bindParam(':email', $this->email);
		$STH->bindParam(':cart_items', $this->cart_items);

		// Execute
		$STH->execute();

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}
}

?>