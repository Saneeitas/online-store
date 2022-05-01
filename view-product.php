<?php

session_start();

 require "inc/process.php";
 require "inc/header.php";  
 if(isset($_GET["product_id"]) && !empty($_GET["product_id"])){
     $id = $_GET["product_id"];
     //sql & query
     $sql = "SELECT * FROM products WHERE id ='$id' ";
     $query = mysqli_query($connection,$sql);
     //result
     $result = mysqli_fetch_assoc($query);
 }else{
     header("location: index.php");
 }
 //session to store url
 $_SESSION["url"] = $_GET["product_id"];
?>
<script src="http://localhost/Frameworks/Jquery/jquery-3.5.1.js"></script>
<link rel="stylesheet" type="text/css" href="http://localhost/Frameworks/iziToast/iziToast.min.css" >
<script src="http://localhost/Frameworks/iziToast/iziToast.min.js" ></script>
<div class="container">
<?php require './pages/header-home.php'; ?>
 <div class="container-fluid my-3">
    <div class="row">
        <div class="col-8">
            <?php 
         if(isset($error)) {
            ?>
            <div class="alert alert-danger">
                <strong><?php echo $error ?></strong>
            </div>
            <?php
         }elseif (isset($success)) {
            ?>
            <div class="alert alert-success">
            <strong><?php echo $success ?></strong>
            </div>
            <?php
        }
        ?>

            <hr>
            <div class="row bg-dark mb-2">
                <div class="col-6 text-white" style="background-color:#FF6347;">Date posted:
                     <?php echo date("F j,Y", strtotime($result["timestamp"])) ?>
                </div>
                <div class="col-6 text-end text-white" style="background-color:#FF6347;">Category: 
                    <?php 
                    $cid = $result["category_id"];
                    //sql & query to get category_id name
                    $sql2 ="SELECT * FROM category WHERE id='$cid' ";
                    $query2 = mysqli_query($connection,$sql2);
                    $result2 = mysqli_fetch_assoc($query2);
                    echo $result2["name"];
                     ?>
                </div>
                
            </div>
            <div class="text-center">
                <img style="width:250px; height:250px;" src="<?php echo $result["image"] ?>" alt="">
            </div>
            <div class="content">
                <b><i>Description :</i></b>
               <hr/>
                <p>
                    <?php echo $result["content"] ?>
                </p>
            </div>
           <hr/>
            <div>
                <!--adding to cart using ajax aproache-->
                <form id="submitform" action="" method="post">
                    <div class="form-group">
                        <label for="quantity" class="mb-2"><b><i>Quantity :</i></b></label>
                        <input type="number" class="form-control w-25" name="quantity" value="1" id="">
                    </div>
                <input type="hidden" name="product_id" value="<?php echo $id ?>" id="">
                <input type="hidden" name="addtocart" value="1">
                <button class="btn mt-2"  style="background-color:#FF6347;">
                <i class="fas fa-cart-plus"></i> ADD TO CART </button>    
                </form>
                
               <!-- <a href="javascripts:;" class="btn btn-primary">Add to cart</a> -->
           </div>

                
                
        </div> 
        <div class="col-4">
            <!--Side bar--->
            <div class="border p-3">
                <form action="search.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="search" placeholder="Enter Search term" id="" >
                    </div>
                    <button type="submit" class="btn btn- mt-2" style="color:#FF6347;">
                    <i class="fas fa-search"></i> Search</button>

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
<script>
   $(document).ready(function () {
      $("#submitform").submit(function (e) { 
          e.preventDefault();
          let form = $(this);
          let formdata = form.serialize();
          //making my first jquery ajax
          $.ajax({
              type: "POST",
              url: "ajax.php",
              data: formdata,
              success: function (response) {
                  //iziToast nofification
                  iziToast.success({
                      title: 'info',
                      message: "Successfully added to cart <a href='cart.php'>Go to cart</a>",
                  });                
              }
          });
          
      });
   });
</script>


<?php
 require "inc/footer.php"; 
 ?>

