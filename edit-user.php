<?php  
session_start();

//check if user is not logged in
if(!isset($_SESSION["user"])){
    header("location: login.php");
}//check if logged in as user
if($_SESSION["user"]["role"] == "user"){
    header("location: index.php");
}

//header links
 require "inc/header.php"; ?>

 <div class="container">

 <?php
 //header content
 require './pages/header-home.php';
 include 'inc/process.php'; 
 //if user click edit
if(isset($_GET["edit_user_id"]) && !empty($_GET["edit_user_id"])){
    $edit_user_id = $_GET["edit_user_id"];
    //sql
    $sql = "SELECT * FROM users WHERE id = '$edit_user_id'";
    $query = mysqli_query($connection,$sql);
    $result = mysqli_fetch_assoc($query);
}else{
    header("location: users.php");

}
 ?>

 <div class="container p-3">
     <div class="row">
         <div class="col-12">
             <div class="row">
                 <div class="col-6"> 
                     <h4>Welcome <?php  echo $_SESSION["user"]["name"]; ?></h4>  
                 </div>
                 <div class="col-6">
                      <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
                 </div>
             </div>
         </div>
         <div class="col-3">
             <h5 class="list-group-item " style="color:#FF6347;">
              <i class="fas fa-ellipsis-v"></i> NAVIGATIONS</h5>
             <ul class="list-group">
                 <li class="list-group-item" style="color:#FF6347;">
                     <a href="category.php" class="btn">
                         <i class="fas fa-grip-vertical" style="color:#FF6347;"></i> CATEGORIES</a>
                 </li>    
                 <li class="list-group-item" style="color:#FF6347;">
                     <a href="users.php" class=" btn text-danger">
                         <i class="fas fa-users" style="color:#FF6347;"></i> USERS</a>
                 </li>
                 <li class="list-group-item" style="color:#FF6347;">
                     <a href="new-user.php" class="btn">
                         <i class="fas fa-user-plus" style="color:#FF6347;"></i> ADD NEW USER</a>
                 </li>
                 <li class="list-group-item" style="color:#FF6347;">
    <a href="products.php" class="btn">
        <i class="fas fa-boxes" style="color:#FF6347;"></i> ALL PRODUCTS</a>
</li>
<li class="list-group-item" style="color:#FF6347;">
     <a href="new-products.php" class="btn">
         <i class="fas fa-plus" style="color:#FF6347;"></i> NEW PRODUCT</a>
</li>
<li class="list-group-item" style="color:#FF6347;">
     <a href="orders.php" class="btn">
         <i class="fas fa-shopping-cart" style="color:#FF6347;"></i> ORDERS</a>
</li>
        </ul>
        </div>
        
         <div class="col-9">
             <div class="container">
                 <h6>Edit Users</h6>
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
                 <form action="" method="post">
                     <div class="form-group">
                         <label for="">Name</label>
                         <input type="text" name="name" value="<?php echo $result["name"];?>"
                         placeholder="Enter new name" class="form-control" id="">
                     </div>
                     <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" value="<?php echo $result["email"];?>"
                        placeholder="Enter new email" class="form-control" id="">
                        </div>  
                    <div class="form-group">
                        <label for="">Role</label>
                        <select name="role" class="form-control"id="">
                            <option value="Admin" 
                            <?php echo $result["role"] == "admin" ? 'selected' : '' ?>
                             >Admin</option>
                            <option value="User" 
                            <?php echo $result["role"] == "user" ? 'selected' : '' ?>
                            >User</option>
                        </select>
                    </div>
                        <div class="form-group my-2">
                            <label for="">Change password</label>
                            <input type="checkbox" name="change_password" id="">
                        </div>    
                    <div class="form-group">
                        <label for="">New Password</label>
                        <input type="password" name="password"
                         placeholder="Enter new password" class="form-control" id="">
                      </div>
                     <div class="form-group">
                         <button type="submit" name="edit_user" class="btn btn-sm btn-primary my-2">
                             Update</button>
                     </div>
                 </form>
             </div> 
         </div>
     </div>
 </div>

<?php  
//footer content
require './pages/footer-home.php'; ?>

 </div>


 <?php
 //footer script
  require "inc/footer.php";  ?>