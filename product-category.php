<?php
session_start();
 require "inc/process.php";
 require "inc/header.php";

 if(isset($_GET["product_category_id"]) && !empty($_GET["product_category_id"])){
   $id = $_GET["product_category_id"];
 }else{
   header("location: index.php");   
 }
 
 ?>

<div class="container">
<?php require './pages/header-home.php'; ?>
 <div class="container-fluid my-3">
    <div class="row justify-content-center">
      <div class="col-8">
        <div class="border p-3"> 
        <ul style="display:flex; list-style-type:none;">
        <?php
        $sql_c ="SELECT * FROM category ORDER BY id DESC";
        $query_c = mysqli_query($connection,$sql_c);
        $count = 0;
        while ($result_c = mysqli_fetch_assoc($query_c)) { 
            ?>
              <li style="<?php echo $count >0 ? 'margin-left:10px;' : '' ?>">
                  <a href="product-category.php?product_category_id=<?php echo $result_c["id"]; ?>" 
                  class="<?php echo $result_c["id"] == $id? 'text-danger' : '' ?> btn"  >
                   <?php echo $result_c["name"]; ?></a>
              </li>
            <?php
             $count++;
        }
     ?>
        </ul>
 </div>
        </div>
        <div class="col-8">
            <div class="row">
              <?php
              $sql = "SELECT * FROM products WHERE category_id ='$id' ORDER BY id DESC";
              $query = mysqli_query($connection,$sql);
               while($result = mysqli_fetch_assoc($query)) { 
                //Looping through the col for multiples product
                ?>
              <div class="col-4 mt-2">
              <div class="card" >
           <img src="<?php echo $result["image"]; ?>" style="height:200px; width:100%" 
           class="card-img-top">
           <div class="card-body">
         <h5 class="card-title"><?php echo $result["title"]; ?></h5>
         <h5 class="card-title">N<?php echo number_format($result["price"]); ?></h5>
        <a href="view-product.php?product_id=<?php echo $result["id"]; ?>" class="btn  btn-sm" style="background-color:#FF6347;">
        <i class="fas fa-eye"></i> VIEW PRODUCT</a>
      </div>
     </div>
</div>
            <?php
            }
          ?>
     </div>   
  </div>    

 </div>
     </div>
     <?php require './pages/footer-home.php'; ?>
  </div>

 <?php
 require "inc/footer.php"; 
 ?>

