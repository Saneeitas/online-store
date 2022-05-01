<?php  
session_start();

//header links
 require "inc/header.php"; ?>
 
 
 <script src="http://localhost/Frameworks/Jquery/jquery-3.5.1.js"></script>
<link rel="stylesheet" type="text/css" href="http://localhost/Frameworks/iziToast/iziToast.min.css" >
<script src="http://localhost/Frameworks/iziToast/iziToast.min.js" ></script>

<div class="container">
 <?php
 //header content
 require './pages/header-home.php';
 include 'inc/process.php'; ?>

<div class="py-3">
    <div class="row">
        <div class="col-6">
           <h2>Cart Page (<?php echo isset($_SESSION["cart"]) ?
            count($_SESSION["cart"]) : 0 ?>)</h2>
        </div>
        <div class="col-6">
           <a href="checkout.php" class="btn btn-sm float-end" style="background-color:#FF6347;"><i class="fas fa-baby-carriage"></i> CHECKOUT</a> 
        </div>
    </div>
    <hr>
    <div class="row">
    <?php 
       if (isset($_SESSION["cart"])){
        foreach ($_SESSION["cart"] as $pid => $quantity){
            $quantity = $quantity["quantity"];
            //Get Data
            $sql = "SELECT * FROM products WHERE id = '$pid'";
            $query = mysqli_query($connection,$sql);
            $result = mysqli_fetch_assoc($query);
            ?>
            <div class="col-3"> 
            <div class="card " >
                <img src="<?php echo $result["image"]; ?>" style="height:200px; width:100%" 
                class="card-img-top">
                <div class="card-body">
                <h5 class="card-title"><?php echo $result["title"]; ?></h5>
                <div class="d-flex">
                    <div class="w-100"> <p>Quantity: <?php echo $quantity ?></p></div>
                    <div class="w-100"> <p class="text-end">N<?php echo number_format($result["price"]*$quantity); ?></p></div>
                </div>
                    <a id="submitform" href="?product_id_remove=<?php echo $result["id"]; ?>"
                     class="btn" style="background-color:#FF6347;"><i class="fas fa-trash"></i> REMOVE
                </a>
                </div>
             </div>
            
         </div>
       <?php
       }
    }else{
        ?>
        <h2 class="text-center">Cart is not active </h2>
        <?php
    }
     ?>
   </div>  
</div>    

<?php  
//footer content
require './pages/footer-home.php'; ?>

 </div>


 <?php
 //footer script
  require "inc/footer.php";  ?>