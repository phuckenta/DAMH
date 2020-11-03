<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/brand.php';?>

<?php
 	// gọi class cat
	 $brand = new brand(); 
	 
	//  kt nếu tồn tại biến get delid thì gán cho id
	 if(isset($_GET['delid'])){
		$id = $_GET['delid']; // Lấy delid trên host
		$delbrand = $brand -> del_brand   ($id); 
	}
	
  ?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Danh sách thương hiệu</h2>
                <div class="block">    
				<?php 
					if(isset($delbrand)){
                        echo $delbrand;
                    }
				?>
				    
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>TT</th>
							<th>Tên thương hiệu</th>
							<th>Hành động</th>
						</tr>
					</thead>
					<tbody>
					 <?php 
					//  Số TT danh mục tăng dần
						 $show_brand = $brand->show_brand();
						 if($show_brand){
							 $i = 0;
							 while($result = $show_brand->fetch_assoc()){
								$i++;
							 
						 
					 ?>
						<!-- Lấy tên catName từ phpAdmin -->
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $result['brandName'] ?></td>

							<td><a href="brandedit.php?brandId=<?php echo $result['brandId'] ?>">Sửa</a> || <a onclick="return confirm('Bạn có muốn xóa danh mục này không?')" href="?delid=<?php echo $result['brandId'] ?>">Xóa</a></td>
						</tr>
						<?php 
					}
						}
						?>

					</tbody>
				</table>
               </div>
            </div>
        </div>
<script type="text/javascript">
	$(document).ready(function () {
	    setupLeftMenu();

	    $('.datatable').dataTable();
	    setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php';?>

