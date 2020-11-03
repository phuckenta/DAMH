<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>


 
<?php 
	/**
	* 
	*/
	class category
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function insert_category($catName){
			$catName = $this->fm->validation($catName); //gọi ham validation từ file Format để ktra
			$catName = mysqli_real_escape_string($this->db->link, $catName);
			 //mysqli gọi 2 biến. (catName and link) biến link -> gọi conect db từ file db
			
			if(empty($catName)){
				$alert = "<span class='error'>Không nên để trống danh mục</span>";
				return $alert;
			}else{
				$query = "INSERT INTO tbl_category(catName) VALUES('$catName') ";
				$result = $this->db->insert($query);
				if($result){
					$alert = "<span class='success'>Thêm danh mục thành công</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Thêm danh mục không thành công</span>";
					return $alert;
				}
			}
		}
		public function show_category()
		{	
			// sắp xếp danh mục được thêm trước
			$query = "SELECT * FROM tbl_category order by catId desc ";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_category($catName,$id)
		{
			$catName = $this->fm->validation($catName); //gọi ham validation từ file Format để ktra
			$catName = mysqli_real_escape_string($this->db->link, $catName);
			$id = mysqli_real_escape_string($this->db->link, $id);
			if(empty($catName)){
				$alert = "<span class='error'>Không nên để trống danh mục</span>";
				return $alert;
			}else{
				// set catName với điều kiện catId = $id
				$query = "UPDATE tbl_category SET catName= '$catName' WHERE catId = '$id' ";
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
		public function del_category($id)
		{	
			// xóa catName với điều kiện catId = $id
			$query = "DELETE FROM tbl_category where catId = '$id' ";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='success'>Xóa danh mục thành công</span>";
				return $alert;
			}else {
				$alert = "<span class='success'>Xóa danh mục không thành công</span>";
				return $alert;
			}
		}
		// lấy catId từ table category
		public function getcatbyId($id)
		{
			$query = "SELECT * FROM tbl_category where catId = '$id' ";
			$result = $this->db->select($query);
			return $result;
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