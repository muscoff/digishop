<?php  

class PageFive{
	private $table = 'page_five';
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
			$row = $STH->fetch(PDO::FETCH_OBJ);
			return array(
				'id'=>$row->id,
				'first_cap' =>$row->first_cap,
				'second_cap' => $row->second_cap,
				'third_cap' => $row->third_cap,
				'first_link' => $row->first_link,
				'second_link' => $row->second_link,
				'image' => $row->image,
				'created_at' => $row->created_at
 			);
		}else{
			die('Failed to fetch data');
		}
	}

	public function create(){
		// Query Statement
		$query = "INSERT INTO ".$this->table." (`first_cap`, `second_cap`, `third_cap`, `first_link`, `second_link`, `image`) VALUES (:first_cap, :second_cap, :third_cap, :first_link, :second_link, :image)";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean data
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

		// Clean data
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

		// Clean Data
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