<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<!-- gọi 2 class để lấy dữ liệu danh mục và thương hiệu -->
<?php include '../classes/brand.php';?>
<?php include '../classes/category.php';?>
<?php include '../classes/product.php';?>
<?php
    // gọi class category
    $pd = new product();
    if(!isset($_GET['productid']) || $_GET['productid'] == NULL){
        echo "<script> window.location = 'productlist.php' </script>";
        
    }else {
        $id = $_GET['productid']; // Lấy productid trên host
    } 
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        // LẤY DỮ LIỆU TỪ PHƯƠNG THỨC Ở FORM POST
        $updateProduct = $pd -> update_product($_POST, $_FILES, $id); // hàm check catName khi submit lên
    }
  ?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa sản phẩm</h2>
    <!-- notification -->
        <?php 
            if(isset($updateProduct)){
                echo $updateProduct;
            }
         ?>
        <!-- phương thức POST sẽ lấy giá trị dựa vào name -->

        <!-- lấy product id đã lấy được ở trên -->
         <?php 
         $get_product_by_id = $pd->getproductbyId($id);
         if($get_product_by_id){
            while ($result_product = $get_product_by_id->fetch_assoc()) {
             
            
          ?>   
        <div class="block">     

         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Tên sản phẩm</label>
                    </td>
                    <td>
                        <input type="text" name="productName" value="<?php echo $result_product['productName'] ?>" class="medium" />
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Danh mục</label>
                    </td>
                    <td>
                        <select id="select" name="category">
                            <option>-------Chọn danh mục-------</option>
                            <!-- lấy dữ liệu từ trang danh mục với hàm cat -->
                            <?php 
                                $cat = new category();
                                $catlist = $cat->show_category();
            
                                if($catlist){
                                    while($result = $catlist->fetch_assoc()){
                                
                            ?>
                            <!-- catName tương ứng với Id nào sẽ lấy Id đó -->
                            <option 
                            <?php 
                                if($result['catId']==$result_product['catId']){ echo 'selected'; 
                                }
                            ?>
                            
                            value="<?php echo $result['catId'] ?>"><?php echo $result['catName'] ?></option>
                            
                            <?php 
                                }
                            }
                            ?>    
                        </select>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Thương hiệu</label>
                    </td>
                    <td>
                        <select id="select" name="brand">
                            <option>------Chọn thương hiệu------</option>

                            <?php 
                                $brand = new brand();
                                $brandlist = $brand->show_brand();
                                // lấy được catlist
                                if($brandlist){
                                    while($result = $brandlist->fetch_assoc()){
                                
                            ?>
                            <!-- catName tương ứng với Id nào sẽ lấy Id đó -->
                            <option 
                            <?php 
                            if($result['brandId']==$result_product['brandId']){ echo 'selected';}
                            ?>

                            value="<?php echo $result['brandId'] ?>"><?php echo $result['brandName'] ?></option>
                            <?php 
                                }
                            }
                            ?>    
                       

                        </select>
                    </td>
                </tr>
				
				 <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Mô tả</label>
                    </td>
                    <td>
                        <textarea name="product_desc" class="tinymce"><?php echo $result_product['product_desc'] ?></textarea>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Giá</label>
                    </td>
                    <td>
                        <input type="text" name="price" value="<?php echo $result_product['price'] ?>" class="medium" />
                    </td>
                </tr>
            
                <tr>
                    <td>
                        <label>Hình ảnh</label>
                    </td>
                    <td>
                        <img src="uploads/<?php echo $result_product['image'] ?>" width="90px"  height="90px"><br>
                        <input type="file" name="image" />
                    </td>
                </tr>
				
				<tr>
                    <td>
                        <label>Product Type</label>
                    </td>
                    <td>
                        <select id="select" name="type">
                            <option>Select Type</option>
                            <?php 
                                if($result_product['type']==0){

                            ?>
                            <option selected value="1">Featured</option>
                            <option value="0">Non-Featured</option>
                            <?php 
                                }else{
                            ?>   
                            <option  value="1">Featured</option>
                            <option selected value="0">Non-Featured</option>
                            <?php     
                                }

                            ?>      


                        </select>
                    </td>
                </tr>

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" value="Cập nhật" />
                    </td>
                </tr>
            </table>
        </form>
        <?php 
        }

        }
        ?>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>


