<?php
session_start();
 require "inc/process.php";
 require "inc/header.php";
 
 if(isset($_POST["search"])){
     $search = $_POST["search"];
 }else{
     $search = '';
 }
 ?>

<div class="container">
<?php require './pages/header-home.php'; ?>
 <div class="container-fluid my-3">
    <div class="row justify-content-center">
      <div class="col-8">
        <div class="border p-3">
          <form action="search.php" method="post">
            <div class="form-group">
              <h4>Search result for: <?php echo $search; ?></h4>
             <input type="text" class="form-control" name="search" placeholder="Search product" required id="">
            </div>
         <button type="submit" class="btn mt-2 border"  style="color:#FF6347;"><i class="fas fa-search"></i> SEARCH</button>
     </form>
 </div>
        </div>
        <div class="col-8">
            <div class="row">
              <?php
              //displaying the search posts from database
              $searchterm = $_POST["search"];
              $sql = "SELECT * FROM products WHERE title LIKE '%$searchterm%' ORDER BY id DESC";
              $query = mysqli_query($connection,$sql);
               while($result = mysqli_fetch_assoc($query)) { 
                //Looping through the col for multiples post
                ?>
              <div class="col-4 mt-2">
              <div class="card" >
           <img src="<?php echo $result["image"]; ?>" style="height:200px; width:100%" 
           class="card-img-top">
           <div class="card-body">
         <h5 class="card-title"><?php echo $result["title"]; ?></h5>
         <h5 class="card-title">N<?php echo number_format($result["price"]); ?></h5>
        <a href="view-product.php?product_id=<?php echo $result["id"]; ?>" class="btn" style="background-color:#FF6347;">
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

