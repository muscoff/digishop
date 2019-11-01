<?php  

class Category{
	private $table = 'categories';
	private $DBH;
	public $id;
	public $category;
	public $parent;
	public $created_at;

	public function __construct($db){
		$this->DBH = $db;
	}

	public function getParent(){
		// Query Statement
		$query = "SELECT * FROM ".$this->table;

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Execute
		$STH->execute();

		// array container
		$data = array();

		if($STH->rowCount()){
			while($row = $STH->fetch(PDO::FETCH_OBJ)){
				$cat = array(
					'id'=>$row->id,
					'category'=>$row->category,
					'parent'=>$row->parent
				);
				array_push($data, $cat);
			}
			return $data;
		}else{
			die(json_encode(array('msg'=>'No available categories for display')));
		}

		$this->DBH = null;
	}

	public function add(){
		// Query Statement
		$query = "INSERT INTO ".$this->table." (`category`, `parent`) VALUES (:cat, :parent)";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// clean data
		$this->category = htmlspecialchars(strip_tags($this->category));
		$this->parent = htmlspecialchars(strip_tags($this->parent));

		// Bind Data
		$STH->bindParam(':cat', $this->category);
		$STH->bindParam(':parent', $this->parent);

		// Execute
		$STH->execute();

		if($STH->rowCount()){
			return array('msg'=>'Successfully added');
		}else{
			return array('msg'=>'failed to add');
		}

		//$this->DBH = null;
	}

	public function edit(){
		// Query Statement
		$query = "UPDATE ".$this->table." SET `category`=?, `parent`=? WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean data
		$this->category = htmlspecialchars(strip_tags($this->category));
		$this->parent = htmlspecialchars(strip_tags($this->parent));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->category, $this->parent, $this->id]);

		if($STH->rowCount()){
			return array('msg'=>'Successfully updated');
		}else{
			return array('msg'=>'failed update');
		}

		//$this->DBH = null;
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
			return array('msg'=>'Successfully deleted');
		}else{
			return array('msg'=>'Failed to delete');
		}

		//$this->DBH = null;
	}
}

?>