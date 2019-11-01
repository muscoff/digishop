<?php  

class Brand{
	private $table = 'brand';
	public $id;
	public $brand;
	private $DBH;

	public function __construct($db){
		$this->DBH = $db;
	}

	public function fetchBrand(){
		// Query Statement
		$query = "SELECT * FROM ".$this->table;

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		//Execute
		$STH->execute();

		$data = array();

		if($STH->rowCount()){
			while($row = $STH->fetch(PDO::FETCH_OBJ)){
				$brand = array(
					'id' => $row->id,
					'brand' => $row->brand
				);
				array_push($data, $brand);
			}
			return $data;
		}else{
			die('No Data available');
		}

		$this->DBH = null;

	}

	public function addBrand(){
		// Query Statement
		$query = "INSERT INTO ".$this->table." (`brand`) VALUES (:brand)";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// clean data
		$this->brand = htmlspecialchars(strip_tags($this->brand));

		// Bind Params
		$STH->bindParam(':brand', $this->brand);

		// Execute
		$STH->execute();

		if($STH->rowCount()){
			$msg = array('msg'=>'Brand has been successfully added');
			return $msg;
		}else{
			return array('msg'=>'Failed to add');
		}

		$this->DBH = null;

	}

	public function editBrand(){
		// Query Statement
		$query = "UPDATE ".$this->table." SET `brand`=? WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// clean data
		$this->brand = htmlspecialchars(strip_tags($this->brand));
		$this->id = htmlspecialchars(strip_tags($this->id));

		//Execute
		$STH->execute([$this->brand, $this->id]);

		if($STH->rowCount()){
			$msg = array('msg'=>'Brand has been updated successfully');
			return $msg;
		}else{
			return array('msg'=>'Failed to edit');
		}

		$this->DBH = null;
	}

	public function deleteBrand(){
		// Query Statement
		$query = "DELETE FROM ".$this->table." WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// clean data
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->id]);

		if($STH->rowCount()){
			$msg = array('msg'=>'Brand has been deleted successfully');
			return $msg;
		}else{
			die(array('msg'=>'failed to delete'));
		}

		$this->DBH = null;
	}
}

?>