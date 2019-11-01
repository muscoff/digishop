<?php  

class PageTwo{
	private $table = 'page_two';
	private $DBH;
	public $id;
	public $first_cap;
	public $second_cap;
	public $third_cap;
	public $first_link;
	public $second_link;
	public $image;
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

		if($STH->rowCount()){
			$data = $STH->fetch(PDO::FETCH_OBJ);
			return array(
				'id'=> $data->id,
				'first_cap' => $data->first_cap,
				'second_cap' => $data->second_cap,
				'third_cap' => $data->third_cap,
				'first_link' => $data->first_link,
				'second_link' => $data->second_link,
				'image' => $data->image,
				'created_at' => $data->created_at
			);
		}else{
			die('Failed to fatch data');
		}
	}

	public function create(){
		// Query Statement
		$query = "INSERT INTO ".$this->table." (`first_cap`, `second_cap`,`third_cap`, `first_link`, `second_link`, `image`) VALUES (:first_cap, :second_cap, :third_cap, :first_link, :second_link, :image)";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->first_cap = htmlspecialchars(strip_tags($this->first_cap));
		$this->second_cap = htmlspecialchars(strip_tags($this->second_cap));
		$this->third_cap = htmlspecialchars(strip_tags($this->third_cap));
		$this->first_link = htmlspecialchars(strip_tags($this->first_link));
		$this->second_link = htmlspecialchars(strip_tags($this->second_link));

		// Bind Params
		$STH->bindParam(':first_cap', $this->first_cap);
		$STH->bindParam(':second_cap', $this->second_cap);
		$STH->bindParam(':third_cap', $this->third_cap);
		$STH->bindParam(':first_link', $this->first_link);
		$STH->bindParam(':second_link', $this->second_link);
		$STH->bindParam(':image', $this->image);

		// Execute
		$STH->execute();

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function edit(){
		// Query Statement
		$query = "UPDATE ".$this->table." SET `first_cap`=?, `second_cap`=?, `third_cap`=?, `first_link`=?, `second_link`=?, `image`=? WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->first_cap = htmlspecialchars(strip_tags($this->first_cap));
		$this->second_cap = htmlspecialchars(strip_tags($this->second_cap));
		$this->third_cap = htmlspecialchars(strip_tags($this->third_cap));
		$this->first_link = htmlspecialchars(strip_tags($this->first_link));
		$this->second_link = htmlspecialchars(strip_tags($this->second_link));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->first_cap, $this->second_cap, $this->third_cap, $this->first_link, $this->second_link, $this->image, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function delete(){
		// Query Statement
		$query = "DELETE FROM ".$this->table." WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean data
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

}


?>