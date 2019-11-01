<?php  

class PageFour{
	private $table = 'page_four';
	private $DBH;
	public $id;
	public $image;
	public $first_link;
	public $second_link;
	public $third_link;
	public $created_at;

	public function __construct($db){
		$this->DBH = $db;
	}

	public function fetch(){
		// Query Statement
		$query = "SELECT * FROM ".$this->table;

		//Prepare Query
		$STH = $this->DBH->prepare($query);

		//Execute
		$STH->execute();

		if($STH->rowCount()){
			$data = $STH->fetch(PDO::FETCH_OBJ);
			return array(
				'id' => $data->id,
				'image' => $data->image,
				'first_link' => $data->first_link,
				'second_link' => $data->second_link,
				'third_link' => $data->third_link,
				'created_at' => $data->created_at 
			);
		}else{
			die('Fetch failed...');
		}
	}

	public function create(){
		// Query Statement
		$query = "INSERT INTO ".$this->table." (`image`, `first_link`, `second_link`, `third_link`) VALUES (:image, :first_link, :second_link, :third_link)";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean data
		$this->first_link = htmlspecialchars(strip_tags($this->first_link));
		$this->second_link = htmlspecialchars(strip_tags($this->second_link));
		$this->third_link = htmlspecialchars(strip_tags($this->third_link));

		// Bind Params
		$STH->bindParam(':image', $this->image);
		$STH->bindParam(':first_link', $this->first_link);
		$STH->bindParam(':second_link', $this->second_link);
		$STH->bindParam(':third_link', $this->third_link);

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
		$query = "UPDATE ".$this->table." SET `image`=?, `first_link`=?, `second_link`=?, `third_link`=? WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean data
		$this->first_link = htmlspecialchars(strip_tags($this->first_link));
		$this->second_link = htmlspecialchars(strip_tags($this->second_link));
		$this->third_link = htmlspecialchars(strip_tags($this->third_link));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->image, $this->first_link, $this->second_link, $this->third_link, $this->id]);

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