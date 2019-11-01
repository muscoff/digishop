<?php  

class PageSeven{
	private $table = 'page_seven';
	private $DBH;
	public $id;
	public $first_cap;
	public $second_cap;
	public $third_cap;
	public $page_link;
	public $image;
	public $created_at;

	public function __construct($db){
		$this->DBH = $db;
	}

	public function fetch(){
		// Query Statement
		$query = "SELECT * FROM ".$this->table;

		// prepare
		$STH = $this->DBH->prepare($query);

		// Execute
		$STH->execute();

		if($STH->rowCount()){
			$data = $STH->fetch(PDO::FETCH_OBJ);
			return array(
				'id' => $data->id,
				'first_cap' => $data->first_cap,
				'second_cap' => $data->second_cap,
				'third_cap' => $data->third_cap,
				'page_link' => $data->page_link,
				'image' => $data->image,
				'created_at' => $data->created_at
			);
		}else{
			die('Failed to fetch data');
		}
	}

	public function create(){
		// Query Statement
		$query = "INSERT INTO ".$this->table." (`first_cap`, `second_cap`, `third_cap`, `page_link`, `image`) VALUES (:first_cap, :second_cap, :third_cap, :page_link, :image)";

		//Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->first_cap = htmlspecialchars(strip_tags($this->first_cap));
		$this->second_cap = htmlspecialchars(strip_tags($this->second_cap));
		$this->third_cap = htmlspecialchars(strip_tags($this->third_cap));
		$this->page_link = htmlspecialchars(strip_tags($this->page_link));

		// Bind Param
		$STH->bindParam(':first_cap', $this->first_cap);
		$STH->bindParam(':second_cap', $this->second_cap);
		$STH->bindParam(':third_cap', $this->third_cap);
		$STH->bindParam(':page_link', $this->page_link);
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
		$query = "UPDATE ".$this->table." SET `first_cap`=?, `second_cap`=?, `third_cap`=?, `page_link`=?, `image`=? WHERE `id`=?";

		// Prepare
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->first_cap = htmlspecialchars(strip_tags($this->first_cap));
		$this->second_cap = htmlspecialchars(strip_tags($this->second_cap));
		$this->third_cap = htmlspecialchars(strip_tags($this->third_cap));
		$this->page_link = htmlspecialchars(strip_tags($this->page_link));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->first_cap, $this->second_cap, $this->third_cap, $this->page_link, $this->image, $this->id]);

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

		// Clean Data
		$this->id = htmlspecialchars(strip_tags($this->id));

		//Execute
		$STH->execute([$this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}
}

?>