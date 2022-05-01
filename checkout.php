<?php  
session_start();

//header links
 require "inc/header.php"; ?>
 
 <div class="container">

 <?php
 //header content
 require './pages/header-home.php';
 include 'inc/process.php'; ?>
 <?php 
    if (isset($_SESSION["cart"])){
        $total = 0;
        foreach($_SESSION["cart"] as $key => $value){
        $product_id = $key;
        //get product price
        $sql = "SELECT * FROM products WHERE id='$product_id' ";
        $query = mysqli_query($connection,$sql);
        $result = mysqli_fetch_assoc($query);
        //splitting the details
        $price = intval($result["price"]);
        $quantity = intval($value["quantity"]);
        $total1 = $price*$quantity;
        $total +=  $total1;      
     }
    }
?>

<div class="py-3">
    <h2>Checkout</h2>
    <hr> 
    <div class="row">
        <div class="col">
            <?php 
               if (isset($_SESSION["user"])){
                   ?>
                    <h2 class="text-center">Make Payment of #<?php echo number_format($total ?? 0); ?></h2>
                    <hr/>
                    <div class="row">
                      <div class="col-12" id="message" style="display:none;">
                        <div class="alert alert-success">
                          <strong>Verifying payment please wait...</strong>
                        </div>
                      </div>
                       <div class="col-6">
                       <!-- Flutterwave payment -->
                       <h2>Pay with</h2>
                       <img src="assets/img/flutterwave.png" id="flutterpay" 
                        onclick="makePayment()" style="height:100px;" alt="flutterwave.png">
                    </div>
                    <div class="col-6">
                        <!-- Paystack payment -->
                        <h2>Pay with</h2>
                        <img src="assets/img/paystack.png" onclick="payWithPaystack()" id="paystackpay" 
                        style="height:100px;" alt="paystack.png">
                       </div>
                    </div>
                   <?php
               }else{
                   ?>
                    <h2 class="text-center"><a href="login.php">Login</a> to checkout</h2>
                   <?php
               }
            ?>
        </div>
    
   </div>  
</div>    



<?php  
//footer content
require './pages/footer-home.php'; ?>

 </div>

<?php
//checking if user log in
  if (isset($_SESSION["user"])){
      ?>
      <script src="http://localhost/Frameworks/Jquery/jquery-3.5.1.js"></script>
      <script src="https://js.paystack.co/v1/inline.js"></script>
      <script src="https://checkout.flutterwave.com/v3.js"></script>
       <script>

    //Paystack payment api     
function payWithPaystack() {
  let handler = PaystackPop.setup({
    key: 'pk_test_2fff748bbf98578aa20a68b50abb7933655dae0a', // Replace with your public key
    email: "<?php echo $_SESSION["user"]["email"] ?>",
    amount: <?php echo $total ?? 0 ?> * 100,
    ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
    // label: "Optional string that replaces customer email"
    onClose: function(){
      alert('Window closed.');
    },
    callback: function(response){
     let reference = response.reference;
      //ajax
       $.ajax({
   type: "POST",
   url: "ajax.php",
   data: {
     "paystack": reference
   },
   beforeSend: function(){
     $("#message").fadeIn();
     $("#paystackpay").fadeOut();
  },
   success: function (response) {
     if(response.code == 200){
       $("#message").find("strong").html(
       "Payment Successfully made!<br>Now redirecting to orders page..");
       //redirecting to orders page
       window.location.href = "user.php";
     }
   }
 });
      
    }
  });
  handler.openIframe();
}
  //Flutterwave payment api
  function makePayment() {
    var p = FlutterwaveCheckout({
      public_key: "FLWPUBK_TEST-9e6996ddee197d8250405bee63bb07c8-X",
      tx_ref: "<?php echo "BHC_".substr(rand(0, time()),0,6); ?>",
      amount: <?php echo $total ?? 0; ?>,
      currency: "NGN",
      country: "NG",
      payment_options: " ",
      customer: {
        email: "<?php echo $_SESSION["user"]["email"] ?>",
        phone_number: " ",
        name: "<?php echo $_SESSION["user"]["name"] ?>",
      },
      callback: function(data){
          console.log(data);
          p.close();
          //make ajax request
          var tx_id = data.transaction_id;
          $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
              "flutterwave": tx_id
            },
            beforeSend: function(){
              $("#message").fadeIn();
              $("#flutterpay").fadeOut();
           },
            success: function (response) {
              if(response.code == 200){
                $("#message").find("strong").html(
                "Payment Successfully made!<br>Now redirecting to orders page..");
                //redirecting to orders page
                window.location.href = "user.php";
              }
            }
          });
      },
      onclose: function(){
          alert("payment cancelled");
      },
      customizations: {
        title: "Product Checkout",
        description: "Payment for item in cart",
       // logo: "https://www.logolynx.com/images/logolynx/22/2239ca38f5505fbfce7e55bbc0604386.jpeg",
      },
    });
  }
</script>
      <?php
  }

?>

 <?php
 //footer script
  require "inc/footer.php";  ?>