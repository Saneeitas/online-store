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
 ?>

 <div class="container p-3">
     <div class="row">
         <div class="col-12">
             <div class="row">
                 <div class="col-6"> 
                     <h4>Welcome <?php  echo $_SESSION["user"]["name"]; ?></h4>  
                 </div>
                 <div class="col-6">
                      <a href="logout.php" class="btn btn-sm btn-danger"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
                 </div>
             </div>
</div>
<div class="col-3">
    <h5 class="list-group-item " style="color:#FF6347;"><i class="fas fa-ellipsis-v"></i> NAVIGATIONS</h5>
    <ul class="list-group">
        <div> 
        <li class="list-group-item" style="color:#FF6347;">
            <a href="category.php" class="btn">
                <i class="fas fa-grip-vertical"style="color:#FF6347;" ></i> CATEGORIES</a>
        </li>    
        <li  class="list-group-item">
            <a href="users.php" class="btn">
                <i class="fas fa-users" style="color:#FF6347;"></i> USERS</a>
        </li>
        <li  class="list-group-item">
            <a href="new-user.php" class="btn">
                <i class="fas fa-user-plus" style="color:#FF6347;"></i> ADD NEW USER</a>
        </li  class="list-group-item">
        <li  class="list-group-item">
            <a href="products.php" class="btn">
                <i class="fas fa-boxes" style="color:#FF6347;"></i> ALL PRODUCTS</a>
        </li  class="list-group-item">
        <li  class="list-group-item">
             <a href="new-products.php" class="btn text-danger">
                 <i class="fas fa-plus" style="color:#FF6347;"></i> NEW PRODUCT</a>
        </li>
        <li  class="list-group-item">
             <a href="orders.php" class="btn">
                 <i class="fas fa-shopping-cart" style="color:#FF6347;"></i> ORDERS</a>
        </li>
        </div>
    </ul>
</div>


         <div class="col-9">
             <div class="container">
                 <h6>Add New Product</h6>
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
                 <form action="" method="post" enctype="multipart/form-data">
                     <div class="form-group">
                         <label for="">Select Thumbnail</label>
                         <input type="file" name="image" id="" class="form-control" required>
                     </div>
                     <div class="form-group">
                         <label for="">Title</label>
                         <input type="text" name="title" placeholder="Enter title"
                          class="form-control" id="" required>
                     </div> 
                     <div class="row">
                         <div class="col-6">
                             <div class="form-group">
                                 <label for="">Status</label>
                                  <select name="status" class="form-control" id="">
                                      <option value="1">Active</option>
                                      <option value="0">Not active</option>
                                  </select>
                             </div>
                         </div>
                        <div class="col-6">
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="category_id" class="form-control" id="">
                                       <?php
                                         $sql = "SELECT * FROM category ORDER BY id DESC";
                                         $query = mysqli_query($connection,$sql);
                                         while($result = mysqli_fetch_assoc($query)){
                                             ?>
                                             <option value="<?php echo $result["id"] ?>">
                                             <?php echo $result["name"] ?>
                                            </option>
                                             <?php
                                         }
                                       ?>  
                                    </select>
                                </div>
                            </div> 
                     </div>
                     <div class="form-group">
                         <label for="">Price</label>
                         <input type="number" name="price" class="form-control"
                          placeholder="Enter product price" id="">
                     </div>
                     <div class="form-group">
                         <label for="">Content</label>
                         <textarea name="content" id="" placeholder="Enter post content" 
                           cols="30" rows="10" class="form-control" required></textarea>
                           </div>   
                           <div class="form-group">
                         <button type="submit" name="new_product" 
                          class="btn btn-sm text-light my-2" style="background-color:#FF6347;">
                          Add <i class="fas fa-plus"></i></button>
                     </div>
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