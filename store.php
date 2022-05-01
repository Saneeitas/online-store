<?php

session_start();

 require "inc/process.php";
 require "inc/header.php";   
?>

<div class="container">
<?php require './pages/header-home.php'; ?>
 <div class="container-fluid my-3">
    <div class="row">
        <div class="col-8">
        <h2>STORE</h2>
            <div class="row">
              <?php
              //displaying the products from database
              $sql = "SELECT * FROM products ORDER BY id DESC";
              $query = mysqli_query($connection,$sql);
               while($result = mysqli_fetch_assoc($query)) { 
                //Looping through the col for multiples product
                ?>
              <div class="col-4 mt-2">
              <div class="card">
           <img src="<?php echo $result["image"]; ?>" style="height:200px; width:100%" 
           class="card-img-top">
           <div class="card-body">
         <h5 class="card-title"><?php echo $result["title"]; ?></h5>
         <h5 class="card-title">N<?php echo number_format($result["price"]); ?></h5>
        <a href="view-product.php?product_id=<?php echo $result["id"]; ?>"
         class="btn btn-sm" style="background-color:#FF6347;"><i class="fas fa-eye"></i> VIEW PRODUCT</a>
      </div>
     </div>
</div>
            <?php
            }
          ?>
     </div>   
  </div>    
        <div class="col-4">
            <!--Side bar--->
            <div class="border p-3 bg-light">
                <form action="search.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="search" placeholder="Search products" required id="" >
                    </div>
                    <button type="submit" class="btn btn-sm mt-2" style="color:#FF6347;">
                    <i class="fas fa-search"></i> SEARCH</button>

                </form>
            </div>

            <div class="border p-3 my-3">
                <h4 class="list-group-item" style="color:#FF6347;">
                <i class="fas fa-grip-vertical"></i> CATEGORIES</h4>
                <ul class="list-group">
  <?php
  $sql_c = "SELECT * FROM category ORDER BY id DESC";
  $query_c = mysqli_query($connection,$sql_c);
  while ($result_c = mysqli_fetch_assoc($query_c)) { 
           ?>
             <li class="list-group-item bg-light" style="background-color:#FF6347;">
             <i class="fas fa-chevron-circle-right" style="color:#FF6347;"></i>
                 <a href="product-category.php?product_category_id=<?php echo $result_c["id"];?>"
                    class="btn">
                 <?php echo $result_c["name"] ?></a>
             </li>
           <?php
            }
          ?>
      </ul>
     </div>                     
         </div>
       </div>
     </div>
     <?php require './pages/footer-home.php'; ?>
  </div>





<?php
 require "inc/footer.php"; 
 ?>

