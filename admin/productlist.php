<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/brand.php';?>
<?php include '../classes/category.php';?>
<?php include '../classes/product.php';?>
<?php include_once '../helpers/format.php';?>
<?php 
	$pd = new product();
	$fm = new Format();
?>


<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh mục sản phẩm</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>ID</th>
					<th>Tên sản phẩm</th>
					<th>Giá</th>
					<th>Hình ảnh</th>
					<th>Danh mục</th>
					<th>Thương hiệu</th>
					<th>Mô tả</th>
					<th>Loại</th>
					<th>Thao tác</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				
				$pdlist = $pd->show_product();
				// nếu lấy được productlist
				if($pdlist){
					// vòng lặp white cho i tăng dần
					$i = 0;
					while($result = $pdlist->fetch_assoc()){
						$i++;
					
				
			?>
				<tr class="odd gradeX">
					<td><?php echo $i ?></td>
					<td><?php echo $result['productName'] ?></td>
					<td><?php echo $result['price'] ?></td>
					<td><img src="uploads/<?php echo $result['image'] ?>" width="70px"  height="70px"></td>
					<td><?php echo $result['catName'] ?></td>
					<td><?php echo $result['brandName'] ?></td>
					<td><?php echo $fm->textShorten($result['product_desc'], 20) ?></td>
					<td><?php
						if($result['type']==0){
							echo 'Feathered';
						}else{
							echo 'Non-Feathered';
						}
					?></td>
						

					
						<td><a href="productedit.php?productid=<?php echo $result['productId'] ?>">Sửa</a> || <a href="?productid=<?php echo $result['productId'] ?>">Xóa</a></td>
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
