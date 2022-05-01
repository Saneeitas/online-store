<?php  
session_start();

//check if user is not logged in
if(!isset($_SESSION["user"])){
    header("location: login.php");
}
//check if logged in as admin
if($_SESSION["user"]["role"] == "user"){
    header("location: user.php");
}

//header links
 require "inc/header.php"; 

 //getting order id data
if(isset($_GET["order_id"]) && !empty($_GET["order_id"])){
    $order_id_data = $_GET["order_id"];
    //getting order status from DB
    $sql_get = "SELECT * FROM orders WHERE order_id = '$order_id_data' LIMIT 1";
    $query_get = mysqli_query($connection,$sql_get);
    $result_get = mysqli_fetch_assoc($query_get);
}
 
 ?>
 
 <link rel="stylesheet" href="http://localhost/Frameworks/Bootstrap/dataTables.bootstrap5.min.css">
 <div class="container">

 <?php
 //header content
 require './pages/header-home.php';
 include 'inc/process.php'; ?>

<div class="py-3">
    <div class="row">
        <div class="col-6"><h2>User Dashboard</h2></div>
        <div class="col-6"><a href="orders.php" class="btn border" style="color:#FF6347;"><h6>ALL ORDERS</h6></a></div>
    </div>
    <hr> 
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
    <div class="row">
       <h3>Order ID :: <?php echo $order_id_data ?></h3>
       <h4>Order Status :: <?php echo $result_get["status"] ?></h4>
       <div class="form-group">
           <form action="" method="post">
               <label for="">Change Status</label>
               <select name="order_status" class="form-control w-25" id="">
                   <option value="Processing"
                     <?php echo $result_get["status"] == "Processing" ? 
                     "selected" : ""; ?>>Processing</option>
                   <option value="Completed"
                     <?php echo $result_get["status"] == "Completed" ? 
                     "selected" : ""; ?>>Completed</option>
                   <option value="Cancelled"
                     <?php echo $result_get["status"] == "Cancelled" ? 
                     "selected" : ""; ?>>Cancelled</option>
               </select>
               <button class=" btn btn-sm text-light my-2" style="background-color:#FF6347;" >Change status</button>
           </form>
       </div>
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
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
              <?php
                $user_id = $_SESSION["user"]["id"];
                $sql = "SELECT * FROM orders WHERE order_id = '$order_id_data'
                        ORDER BY id DESC";
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
                        <td><a class="btn" href="vieworder.php?order_id=<?php echo $result["order_id"] ?>">
                        <i class="fas fa-eye"></i> View Order</a></td>
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
                <th>Action</th>
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