<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>


 
<?php 
	/**
	* 
	*/
	class brand
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function insert_brand($brandName){
			$brandName = $this->fm->validation($brandName); //gọi ham validation từ file Format để ktra
			$brandName = mysqli_real_escape_string($this->db->link, $brandName);
			 //mysqli gọi 2 biến. (catName and link) biến link -> gọi conect db từ file db
			
			if(empty($brandName)){
				$alert = "<span class='error'>Không nên để trống thương hiệu</span>";
				return $alert;
			}else{
				$query = "INSERT INTO tbl_brand(brandName) VALUES('$brandName') ";
				$result = $this->db->insert($query);
				if($result){
					$alert = "<span class='success'>Thêm thương hiệu thành công</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Thêm thương hiệu không thành công</span>";
					return $alert;
				}
			}
		}
		public function show_brand()
		{	
			// sắp xếp thương hiệu được thêm trước
			$query = "SELECT * FROM tbl_brand order by brandId desc ";
			$result = $this->db->select($query);
			return $result;
        }
        // lấy brandId từ table brand
        public function getbrandbyId($id)
		{
			$query = "SELECT * FROM tbl_brand where brandId = '$id' ";
			$result = $this->db->select($query);
			return $result;
		}



		public function update_brand($brandName,$id)
		{
			$brandName = $this->fm->validation($brandName); //gọi ham validation từ file Format để ktra
			$brandName = mysqli_real_escape_string($this->db->link, $brandName);
			$id = mysqli_real_escape_string($this->db->link, $id);
			if(empty($brandName)){
				$alert = "<span class='error'>Không nên để trống thương hiệu</span>";
				return $alert;
			}else{
				// set brandName với điều kiện brandId = $id
				$query = "UPDATE tbl_brand SET brandName= '$brandName' WHERE brandId = '$id' ";
				$result = $this->db->update($query);
				if($result){
					$alert = "<span class='success'>Cập nhật thương hiệu thành công</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Cập nhật thương hiệu không thành công</span>";
					return $alert;
				}
			}

		}
		public function del_brand($id)
		{	
			// xóa catName với điều kiện catId = $id
			$query = "DELETE FROM tbl_brand where brandId = '$id' ";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='success'>Xóa thương hiệu thành công</span>";
				return $alert;
			}else {
				$alert = "<span class='success'>Xóa thương hiệu không thành công</span>";
				return $alert;
			}
		}
		

		public function show_category_fontend()
		{
			$query = "SELECT * FROM tbl_category order by catId desc ";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_product_by_cat($id)
		{
			$query = "SELECT * FROM tbl_product where catId = '$id' order by catId desc LIMIT 8";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_name_by_cat($id)
		{
			$query = "SELECT tbl_product.*,tbl_category.catName,tbl_category.catId 
					  FROM tbl_product,tbl_category 
					  WHERE tbl_product.catId = tbl_category.catId
					  AND tbl_product.catId ='$id' LIMIT 1 ";
			$result = $this->db->select($query);
			return $result;
		}
	}
 ?>