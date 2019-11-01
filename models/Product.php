<?php  

class Product{
	private $table = 'products';
	private $DBH;
	public $id;
	public $title;
	public $price;
	public $brand;
	public $parent_cat;
	public $child_cat;
	public $image;
	public $description;
	public $featured;
	public $sizes;
	public $sold;
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

		// Data array
		$data = array();

		if($STH->rowCount()){
			while($row = $STH->fetch(PDO::FETCH_OBJ)){
				$item = array('id'=>(int)$row->id, 'title'=>$row->title, 'price'=>$row->price, 'brand'=>(int)$row->brand, 'parent_cat'=>(int)$row->parent_cat, 'child_cat'=>(int)$row->child_cat, 'image'=>$row->image, 'description'=>$row->description, 'featured'=>$row->featured, 'sizes'=>$row->sizes, 'sold'=>$row->sold, 'created_at'=>$row->created_at);
				array_push($data, $item);
			}
			return $data;
		}else{
			echo 'NO Data available';
		}
	}

	public function add(){
		// Query Statement
		$query = "INSERT INTO ".$this->table." (`title`, `price`, `brand`, `parent_cat`, `child_cat`, `image`, `description`, `sizes`) VALUES (:title, :price, :brand, :parent, :child, :image, :description, :sizes)";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->title = htmlspecialchars(strip_tags($this->title));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->brand = htmlspecialchars(strip_tags($this->brand));
		$this->parent_cat = htmlspecialchars(strip_tags($this->parent_cat));
		$this->child_cat = htmlspecialchars(strip_tags($this->child_cat));
		// $this->image = htmlspecialchars(strip_tags($this->image));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->sizes = htmlspecialchars(strip_tags($this->sizes));

		// Bind Data
		$STH->bindParam(':title', $this->title);
		$STH->bindParam(':price', $this->price);
		$STH->bindParam(':brand', $this->brand);
		$STH->bindParam(':parent', $this->parent_cat);
		$STH->bindParam(':child', $this->child_cat);
		$STH->bindParam(':image', $this->image);
		$STH->bindParam(':description', $this->description);
		$STH->bindParam(':sizes', $this->sizes);

		// Execute
		$STH->execute();

		if($STH->rowCount()){
			return array('msg'=>'success');
		}else{
			return array('msg'=>'failed');
		}
	}

	public function updateFeatured(){
		// Query Statement
		$query = "UPDATE ".$this->table." SET `featured`= ? WHERE `id` = ?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->featured = htmlspecialchars(strip_tags($this->featured));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->featured, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

// This function returns the image locations
	public function fetch_single(){
		// Query Statement
		$query = "SELECT * FROM ".$this->table." WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Execute
		$STH->execute([$this->id]);

		if($STH->rowCount()){
			$data = $STH->fetch(PDO::FETCH_OBJ);
			$returnData = array(
				'id'=>(int)$data->id,
				'title'=>$data->title,
				'price'=>$data->price,
				'brand'=>$data->brand,
				'parent_cat'=>(int)$data->parent_cat,
				'child_cat'=>(int)$data->child_cat,
				'image'=>$data->image,
				'description'=>$data->description,
				'featured'=>$data->featured,
				'sizes'=>$data->sizes,
				'sold'=>$data->sold,
				'created_at'=>$data->created_at
			);
			return $returnData;
		}else{
			return(array('msg'=>'Failed to get data'));
		}
	}

	public function edit(){
		// Query Statement
		$query = "UPDATE ".$this->table." SET `title`=?, `price`=?, `brand`=?, `parent_cat`=?, `child_cat`=?, `description`=?, `sizes`=? WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		$this->title = htmlspecialchars(strip_tags($this->title));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->brand = htmlspecialchars(strip_tags($this->brand));
		$this->parent_cat = htmlspecialchars(strip_tags($this->parent_cat));
		$this->child_cat = htmlspecialchars(strip_tags($this->child_cat));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->sizes = htmlspecialchars(strip_tags($this->sizes));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->title, $this->price, $this->brand, $this->parent_cat, $this->child_cat, $this->description, $this->sizes, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function updateSizeFromCart(){
		// query 
		$query = "UPDATE ".$this->table." SET `sizes`=? WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean id
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->sizes, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function update_images(){
		// Query Statement
		$query = "UPDATE ".$this->table." SET `image`=? WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		// $this->image = htmlspecialchars(strip_tags($this->image));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->image, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function product_face(){
		// Query Statement
		$query = "UPDATE ".$this->table." SET `image`=? WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		// $this->image = htmlspecialchars(strip_tags($this->image));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->image, $this->id]);

		if($STH->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function delete_single_image(){
		// Query Statement
		$query = "UPDATE ".$this->table." SET `image`=? WHERE `id`=?";

		// Prepare Statement
		$STH = $this->DBH->prepare($query);

		// Clean Data
		// $this->image = htmlspecialchars(strip_tags($this->image));
		$this->id = htmlspecialchars(strip_tags($this->id));

		// Execute
		$STH->execute([$this->image, $this->id]);

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