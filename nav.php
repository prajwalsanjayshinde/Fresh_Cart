<?php
 if(!isset($_SESSION)) 
 { 
     session_start(); 
 } 
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <link rel="stylesheet" href="css/nav.css">

  <style>

  </style>
</head>

<div class="topnav" id="myTopnav">
  <a href="index.php" class="active">Home</a>
  <a href="catalogue.php">Catalog</a>
  <?php
      if(isset($_SESSION['username']))
      {
        if($_SESSION['accountid']==40)
        {
          echo "<a href='additem.php'>Add Inventory</a>";
          echo "<a href='sendmailfrontend.php'>Send Emails</a>";
        }
      }
  ?>

  <div class="topnav-right">
 


    <?php
      if(isset($_SESSION['username']))
      {
        $uname=$_SESSION['username'];
        print <<< END
        <a href="wishlist.php">Wishlist</a>
        <a href="orders.php">Orders</a>
          <a href="cart.php">Cart</a>
        <div class="dropdown">
    <button class="dropbtn">Hey $uname!
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>
END;
    
      }
      else
      {
        echo "<a href='signin.php'>Log In</a>";
      }
    ?>
    <!--<a href=" signup.php " >Signup</a>-->



  <a href=" javascript:void(0); " style=" font-size:15px; " class=" icon " onclick=" myFunction() ">&#9776;</a>
  </div>
</div>













<script>
function myFunction() {
  var x = document.getElementById(" myTopnav ");
  if (x.className === " topnav ") {
    x.className += " responsive ";
  } else {
    x.className = " topnav ";
  }
}

</script>

</html>