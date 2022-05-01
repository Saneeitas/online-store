<?php  
session_start();

//check if user is not logged in
if(!isset($_SESSION["user"])){
    header("location: login.php");
}
//check if logged in as admin
if($_SESSION["user"]["role"] == "admin"){
    header("location: dashboard.php");
}

//header links
 require "inc/header.php"; ?>
 
 <link rel="stylesheet" href="http://localhost/Frameworks/Bootstrap/dataTables.bootstrap5.min.css">
 <div class="container">

 <?php
 //header content
 require './pages/header-home.php';
 include 'inc/process.php'; ?>

<div class="py-3">
    <h2>User Dashboard</h2>
    <hr> 
    <div class="row">
       <h3>Recent Orders</h3>
       <table id="myorders" class="table table-tripped" style="width: 100%;">
          <thead>
              <tr>
                  <th>Order ID</th>
                  <th>Amount</th>
                  <th>Method</th>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Status</th>
                  <th>Date</th>
              </tr>
          </thead>
          <tbody>
              <?php
                $user_id = $_SESSION["user"]["id"];
                $sql = "SELECT * FROM orders WHERE user_id='$user_id'  ORDER BY id DESC";
                $query = mysqli_query($connection,$sql);
                while($result = mysqli_fetch_assoc($query)){
                    ?>
                    <tr>
                        <td><?php echo $result["order_id"] ?></td>
                        <td>#<?php echo number_format($result["amount"]) ?></td>
                        <td><?php echo $result["payment_method"] ?></td>
                        <td>
                            <?php 
                                  $pid =  $result["product_id"];
                                  //Fetch product from database
                                  $sql2 = "SELECT * FROM products WHERE id='$pid' "; 
                                  $query2 = mysqli_query($connection,$sql2);
                                  $result2 = mysqli_fetch_assoc($query2);
                           ?>
                           <img src="<?php echo $result2["image"] ?>" alt="" style="height:25px; width:25px; 
                             object-fit:cover; object-position:center;">
                           <?php echo $result2["title"] ?>
                        </td>
                        <td><?php echo $result["quantity"] ?></td>
                        <td><?php echo $result["status"] ?></td>
                        <td><?php echo $result["timestamp"] ?></td>
                        </tr>
                    <?php
                }
              ?>
          </tbody>
          <tfoot>
              <tr>
                <th>Order ID</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
          </tfoot>

       </table>
   </div>  
</div>    



<?php  
//footer content
require './pages/footer-home.php'; ?>

<script src="http://localhost/Frameworks/Jquery/jquery-3.5.1.js"></script>
<script src="http://localhost/Frameworks/Bootstrap/jquery.dataTables.min.js"></script>
<script src="http://localhost/Frameworks/Bootstrap/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myorders').DataTable();
    });
</script>
 </div>


 <?php
 //footer script
  require "inc/footer.php";  ?>