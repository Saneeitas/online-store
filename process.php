<?php

require "connection.php";

if(isset($_POST["register"])){

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $encrypt_password = md5($password);

    //check if user exist
    $sql_check = "SELECT * FROM users WHERE email = '$email'";
    $query_check = mysqli_query($connection,$sql_check);
    if(mysqli_fetch_assoc($query_check)){
        //user exists
        $error = "User already exist";
    }else{
         //insert into DB
        $sql = "INSERT INTO users(name,email,password) VALUES('$name','$email','$encrypt_password')";
        $query = mysqli_query($connection,$sql) or die("Cant save data");
        $success = "Registration successfully";
    }  
}

if(isset($_POST["login"])){

    $email = $_POST["email"];
    $password = $_POST["password"];
    $encrypt_password = md5($password);

    //check if user exist
    $sql_check2 = "SELECT * FROM users WHERE email = '$email'";
    $query_check2 = mysqli_query($connection,$sql_check2);
    if(mysqli_fetch_assoc($query_check2)){
       //check if email and password exist
       $sql_check = "SELECT * FROM users WHERE email = '$email' 
       AND password = '$encrypt_password'";
       $query_check = mysqli_query($connection,$sql_check);
          if($result = mysqli_fetch_assoc($query_check)){
                //Login to dashboard
                $_SESSION["user"] = $result;
                   if($result["role"] == "user"){
                       header("location: store.php");            
                   }else{
                      header("location: dashboard.php");
                       } 
                      $success = "User logged in";       
          }else{ 
             //user password wrong
             $error = "User password wrong";
          }  
  }else{
      //user not found
      $error = "User email not found";
  } 
}

if(isset($_POST["category"])){
    $name = $_POST["name"];
    //sql
    $sql = "INSERT INTO category(name) VALUES('$name')";
    $query = mysqli_query($connection,$sql);
    
    if($query){
        $success = "Category added";
    }else{
        $error = "Unable to add category";
    }
}

if(isset($_GET["delete_category"]) && !empty($_GET["delete_category"])){
    $id = $_GET["delete_category"];
    //sql
    $sql = "DELETE FROM category WHERE id = '$id'";
    $query = mysqli_query($connection,$sql);

    if($query){
        $success = "Category deleted";
    }else{
        $error = "Unable to delete category";
    }

}

if(isset($_POST["edit_category"])){
    $name = $_POST["name"];
    $edit_id = $_GET["edit_id"];
    //sql
    $sql = "UPDATE category SET name = '$name' WHERE id = '$edit_id'";
    $query = mysqli_query($connection,$sql);
    if($query){
        $success = "Category updated";
    }else{
        $error = "Unable to update category";
    }

}

if(isset($_POST["new_post"])){
    //uploading to upload folder
    $target_dir = "uploads/";
    $basename = basename($_FILES["thumbnail"]["name"]);
    $upload_file = $target_dir.$basename;
    //move uploaded file
    $move = move_uploaded_file($_FILES["thumbnail"]["tmp_name"],$upload_file);
    if($move){
        $url = $upload_file;
        $title = $_POST["title"];
        $content = $_POST["content"];
        $status = $_POST["status"];
        $category_id = $_POST["category_id"];
        $thumbnail = $url;
        //sql
        $sql = "INSERT INTO posts(title,content,status,category_id,thumbnail) VALUES
                ('$title','$content','$status','$category_id','$thumbnail')";
        $query = mysqli_query($connection,$sql);
        if($query){
           //success message
            $success = "Post published";
        }else{
            $error = "Unable to publish post";
        }  
    }else{
        $error = "Unable to upload image";
    }
}

if(isset($_POST["update_post"])){
    $id = $_GET["edit_post_id"];
    if($_FILES["thumbnail"]["name"] != ""){
        //upload image
        $target_dir = "uploads/";
        $url = $target_dir.basename($_FILES["thumbnail"]["name"]);
        //move uploaded file
        if(move_uploaded_file($_FILES["thumbnail"]["tmp_name"],$url)){
            //update to database
             //parameters 
            $title = $_POST["title"];
            $content = $_POST["content"];
            $status = $_POST["status"];
            $category_id = $_POST["category_id"];
            $thumbnail = $url;    
            //sql
            $sql = "UPDATE posts SET title ='$title', content='$content', 
                    status='$status', category_id='$category_id', thumbnail='$thumbnail'
                    WHERE id='$id' ";
            $query = mysqli_query($connection,$sql);
            //check if
            if($query){
                $success = "Post updated";
            }else{
                $error = "Unable to update post";
            }
        }
    }else{
        //leave the upload image and
        //update to database
        //parameters 
        $title = $_POST["title"];
        $content = $_POST["content"];
        $status = $_POST["status"];
        $category_id = $_POST["category_id"];   
        //sql
        $sql = "UPDATE posts SET title ='$title', content='$content', 
            status='$status', category_id='$category_id'
            WHERE id='$id' ";
        $query = mysqli_query($connection,$sql);
        //check if
        if($query){
        $success = "Post updated";
        }else{
        $error = "Unable to update post";
        }

    }
}

if(isset($_GET["delete_post"]) && !empty($_GET["delete_post"])){
    $id = $_GET["delete_post"];
    //sql
    $sql = "DELETE FROM posts WHERE id = '$id'";
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
        $success = "Post deleted successfully";
    }else{
        $error = "Unable to delete post";
    }
}

if(isset($_POST["edit_user"])){
    //check if change password is click
    if(isset($_POST["change_password"]) && $_POST["change_password"] == "on"){
       //update the user with change_password
       $id = $_GET["edit_user_id"];
       $name = $_POST["name"];
       $email = $_POST["email"];
       $password = md5($_POST["password"]);  
       $role = $_POST["role"];
       //sql and query
       $sql = "UPDATE users SET name='$name', email='$email',
               password='$password', role='$role' WHERE id = '$id' ";
       $query = mysqli_query($connection,$sql);
       //check if
       if($query){
           $success = "User data updated";
       }else{
           $error = "Unable to update data";
       }

    }else{
        //update the data only
        $id = $_GET["edit_user_id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $role = $_POST["role"];    
        //sql and query
        $sql = "UPDATE users SET name='$name', email='$email', role='$role'
                WHERE id = '$id' ";
        $query = mysqli_query($connection,$sql);
        //check if
        if($query){
            $success = "User data updated";
        }else{
            $error = "Unable to update data";
        }
    }
}

if(isset($_GET["delete_user"]) && !empty($_GET["delete_user"])){
    $id = $_GET["delete_user"];
    //sql
    $sql = "DELETE FROM users WHERE id = '$id'";
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
        $success = "User deleted successfully";
    }else{
        $error = "Unable to delete user";
    }
}

if(isset($_POST["new_user_admin"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $password = md5($_POST["password"]);
    //check if user already exist
    $sql_check = "SELECT * FROM users WHERE email = '$email'";
    $query_check = mysqli_query($connection,$sql_check);
    //check if
    if(mysqli_fetch_assoc($query_check)){
        //user already exist
        $error = "User already exist";
    }else{
        //user not found
        //add user
         //sql and query
        $sql = "INSERT INTO users (name,email,password,role)
        VALUES ('$name','$email','$password','$role')";
        $query = mysqli_query($connection,$sql);
        //check if
        if($query){
        $success = "New user added successfully";
        }else{
        $error = "Unable to add new user";
     }

  }

}

if(isset($_POST["comment_new"])){
    $comment = $_POST["comment_new"];
    $user_id = $_SESSION["user"]["id"];
    $post_id = $_GET["post_id"];
    //sql & query
    $sql = "INSERT INTO comments(user_id,message,post_id) VALUES('$user_id','$comment','$post_id')";
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
        $success = "Comment added, waiting moderation";
    }else{
        $error = "Unable to add comment";
    }
}

if(isset($_GET["approve_comment"]) && !empty($_GET["approve_comment"])){
    $comment_id = $_GET["approve_comment"];
    //sql query
    $sql = "UPDATE comments SET status = 1 WHERE id = '$comment_id'";
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
    $success = "Comment approved";
    }else{
    $error = "Unable to approved comment";
   }
}

if(isset($_GET["delete_comment"]) && !empty($_GET["delete_comment"])){
    $comment_id = $_GET["delete_comment"];
    //sql query
    $sql = "DELETE FROM comments WHERE id = '$comment_id'";
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
    $success = "Comment deleted";
    }else{
    $error = "Unable to delete comment";
   }
}

if(isset($_POST["new_product"])){
     //uploading to upload folder
 $target_dir = "uploads/";
 $basename = basename($_FILES["image"]["name"]);
 $upload_file = $target_dir.$basename;
 //move uploaded file
 $move = move_uploaded_file($_FILES["image"]["tmp_name"],$upload_file);
 if($move){
     $url = $upload_file;
     $title = $_POST["title"];
     $content = $_POST["content"];
     $price = $_POST["price"];
     $status = $_POST["status"];
     $category_id = $_POST["category_id"];
     $image = $url;
     //sql
     $sql = "INSERT INTO products(title,image,status,category_id,content,price) VALUES
             ('$title','$image','$status','$category_id','$content','$price')";
     $query = mysqli_query($connection,$sql);
     if($query){
        //success message
         $success = "Product added";
     }else{
         $error = "Unable to add product <br>".mysqli_error($connection);
     }  
 }else{
     $error = "Unable to upload image";
 }
   
}

if(isset($_POST["edit_product"])){
    $id = $_GET["edit_product_id"];
    //update image
    if($_FILES["image"]["name"] != ""){
    //uploading to upload folder
$target_dir = "uploads/";
$basename = basename($_FILES["image"]["name"]);
$upload_file = $target_dir.$basename;
//move uploaded file
$move = move_uploaded_file($_FILES["image"]["tmp_name"],$upload_file);
if($move){
    $url = $upload_file;
    $title = $_POST["title"];
    $content = $_POST["content"];
    $price = $_POST["price"];
    $status = $_POST["status"];
    $category_id = $_POST["category_id"];
    $image = $url;
    //sql
    $sql = "UPDATE products SET title='$title', content='$content' , price='$price' ,
            status='$status' , category_id='$category_id' , image='$image' WHERE id = '$id'";
            
    $query = mysqli_query($connection,$sql);
    if($query){
       //success message
        $success = "Product updated";
    }else{
        $error = "Unable to add product <br>".mysqli_error($connection);
    }  
}else{
    $error = "Unable to upload a new image";
}
  
}else{
    //do not update image
        $title = $_POST["title"];
        $content = $_POST["content"];
        $price = $_POST["price"];
        $status = $_POST["status"];
        $category_id = $_POST["category_id"];
       
        //sql
        $sql = "UPDATE products SET title='$title', content='$content' , price='$price' ,
                status='$status' , category_id='$category_id' WHERE id = '$id'";
        
        $query = mysqli_query($connection,$sql);
        if($query){
        //success message
        $success = "Product updated";
        }else{
        $error = "Unable to add product <br>".mysqli_error($connection);
        }  
}

}

if(isset($_GET["delete_product"]) && !empty($_GET["delete_product"])){
    $id = $_GET["delete_product"];
    //sql
    $sql = "DELETE FROM products WHERE id = '$id'";
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
        $success = "product deleted successfully";
    }else{
        $error = "Unable to delete product";
    }
}

if(isset($_POST["addtocart"])){
    $pid = $_POST["product_id"];
    $quantity = $_POST["quantity"];
    //add to cart
    $query= $_SESSION["cart"][$pid] = [
        "quantity" => $quantity
    ];
    //check if
if($query){
   echo "product added to cart successfully <a href='cart.php'>Go to cart</a>";
}else{
    echo  "Unable to add product";
}
}

if(isset($_GET["product_id_remove"]) && !empty($_GET["product_id_remove"])){
    $pid = $_GET["product_id_remove"];
    //remove from cart
 unset($_SESSION["cart"][$pid]);
    $success = "product removed";
}

if(isset($_POST["flutterwave"])){
   $tx_id = $_POST["flutterwave"];
   $curl = curl_init();

  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$tx_id/verify",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer FLWSECK_TEST-962464e907a581d3fd3bacfc351fb39e-X"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$jsondata = json_decode($response);
header("Content-Type: application/json");
//check if the payment is valid
if($jsondata ->status == "success"){
    //looping through session cart to get product id & quantity
    foreach($_SESSION["cart"] as $pid => $value){

        //getting payment data from flutterwave and session
        $order_id = $jsondata->data->tx_ref;
        $amount = $jsondata->data->amount;
        $user_id = $_SESSION["user"]["id"];
        $product_id = $pid ;
        $quantity = $value["quantity"];
        $status = "Processing..";
        $payment_status = "Paid";
        $payment_method = "Flutterwave";
        //insert into DB table
        $sql = "INSERT INTO orders(order_id,amount,user_id,product_id,quantity,
                            status,payment_status,payment_method)
                VALUES('$order_id','$amount','$user_id','$product_id','$quantity',
                       '$status','$payment_status','$payment_method')";
        $query = mysqli_query($connection,$sql);
    }
        //empty cart
        unset($_SESSION["cart"]);
     //return success message
     $response2 = ["code" => 200];  
     echo json_encode($response2);
}else{
    $response2 = ["code" => 401];
    echo json_encode($response2);
}

}

if(isset($_POST["paystack"])){
    $reference = $_POST["paystack"];
    $curl = curl_init();
  
     curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_test_b8d03dd7d1729d1650f9b9adc0bdbc38755c3838",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  
    $jsondata = json_decode($response);
    header("Content-Type: application/json");
    //check if the payment is valid
    if($jsondata ->status == "true"){
    //looping through session cart to get product id & quantity
    foreach($_SESSION["cart"] as $pid => $value){

        //getting payment data from flutterwave and session
        $order_id = $jsondata->data->reference;
        $amount = $jsondata->data->amount;
        $user_id = $_SESSION["user"]["id"];
        $product_id = $pid ;
        $quantity = $value["quantity"];
        $status = "Processing..";
        $payment_status = "Paid";
        $payment_method = "PayStack";
        //insert into DB table
        $sql = "INSERT INTO orders(order_id,amount,user_id,product_id,quantity,
                status,payment_status,payment_method)
                VALUES('$order_id','$amount','$user_id','$product_id','$quantity',
                '$status','$payment_status','$payment_method')";
        $query = mysqli_query($connection,$sql);
    }
        //empty cart
        unset($_SESSION["cart"]);
     //return success message
     $response2 = ["code" => 200];  
     echo json_encode($response2);
}else{
    $response2 = ["code" => 401];
    echo json_encode($response2);
}
}

if(isset($_POST["order_status"])){
    $status = $_POST["order_status"];
    $order_id = $_GET["order_id"];
    //sql
    $sql = "UPDATE orders SET status ='$status' WHERE order_id ='$order_id' ";
    $query = mysqli_query($connection,$sql);
    if($query){
        $success = "Order updated successfully <br> 
        <a href='vieworder.php?order_id=$order_id'>Reload page</a>";
    }else{
        $error = "Unable to update order";
    }
}



?>