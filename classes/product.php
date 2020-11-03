<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>


 
<?php 
	/**
	* 
	*/
	class product
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function insert_product($data,$files){

            $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
            $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link, $data['price']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);
			 //mysqli gọi 2 biến. (catName and link) biến link -> gọi conect db từ file db
            
            //  kiểm tra image và lấy image cho vào folder upload
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.',$file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "uploads/".$unique_image;
             
			if($productName=="" || $brand=="" || $category=="" || $product_desc=="" || $price=="" || $type=="" || $file_name==""){
				$alert = "<span class='error'>Không nên để trống </span>";
				return $alert;
			}else{
                move_uploaded_file($file_temp,$uploaded_image);
				$query = "INSERT INTO tbl_product(productName,brandId,catId,product_desc,price,type,image) VALUES('$productName','$brand','$category','$product_desc','$price','$type','$unique_image')";
				$result = $this->db->insert($query);
				if($result){
					$alert = "<span class='success'>Thêm danh thành công</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Thêm không thành công</span>";
					return $alert;
				}
			}
		}
		public function show_product()
		{	
			// .* chọn tất cả, 
			$query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
			-- INNER JOIN là 2 table giao nhau
			FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId

			INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId

			 order by tbl_product.productId desc ";
			// sắp xếp danh mục được thêm trước
			// $query = "SELECT * FROM tbl_product order by productId desc ";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_product($data,$files,$id)
		{
			$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
            $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link, $data['price']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);
			 //mysqli gọi 2 biến. (catName and link) biến link -> gọi conect db từ file db
            
            //  kiểm tra image và lấy image cho vào folder upload
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];
			
			$div = explode('.',$file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "uploads/".$unique_image;

			if($productName=="" || $brand=="" || $category=="" || $product_desc=="" || $price=="" || $type==""){
				$alert = "<span class='error'>Không nên để trống </span>";
				return $alert;
			}else{
				if(!empty($file_name)){
					// nếu người dùng chọn ảnh
					if ($file_size > 2048){
						$alert = "<span class='error'>Hình ảnh nên có kích thước nhỏ hơn 2MB!</span>";
						return $alert;

					} elseif(in_array($file_ext, $permited) == false)	{
						$alert = "<span class='error'>U can upload only".implode(',', $permited)."</span>";
						return $alert;
					}
					$query = "UPDATE tbl_product SET 
					productName= '$productName',	
					brandId= '$brand',
					catId= '$category',
					type= '$type',
					price= '$price',
					image= '$unique_image',
					product_desc= '$product_desc'

					WHERE productId = '$id' ";
					
				}else{
					// nếu người dùng k chọn ảnh
					$query = "UPDATE tbl_product SET 
					productName= '$productName',	
					brandId= '$brand',
					catId= '$category',
					type= '$type',
					price= '$price',
		
					product_desc= '$product_desc'

					WHERE productId = '$id' ";
				}	


				// set catName với điều kiện catId = $id
				
				$result = $this->db->update($query);
				if($result){
					$alert = "<span class='success'>Cập nhật danh mục thành công</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Cập nhật danh mục không thành công</span>";
					return $alert;
				}
			}

		}
		public function del_product($id)
		{	
			// xóa catName với điều kiện catId = $id
			$query = "DELETE FROM tbl_product where productId = '$id' ";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='success'>Xóa danh mục thành công</span>";
				return $alert;
			}else {
				$alert = "<span class='success'>Xóa danh mục không thành công</span>";
				return $alert;
			}
		}
		// lấy catId từ table product
		public function getproductbyId($id)
		{
			$query = "SELECT * FROM tbl_product where productId = '$id' ";
			$result = $this->db->select($query);
			return $result;
		}	
		// public function show_category_fontend()
		// {
		// 	$query = "SELECT * FROM tbl_category order by catId desc ";
		// 	$result = $this->db->select($query);
		// 	return $result;
		// }
		// public function get_product_by_cat($id)
		// {
		// 	$query = "SELECT * FROM tbl_product where catId = '$id' order by catId desc LIMIT 8";
		// 	$result = $this->db->select($query);
		// 	return $result;
		// }
		// public function get_name_by_cat($id)
		// {
		// 	$query = "SELECT tbl_product.*,tbl_category.catName,tbl_category.catId 
		// 			  FROM tbl_product,tbl_category 
		// 			  WHERE tbl_product.catId = tbl_category.catId
		// 			  AND tbl_product.catId ='$id' LIMIT 1 ";
		// 	$result = $this->db->select($query);
		// 	return $result;
		// }
	}
 ?>