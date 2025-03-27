<?php require 'config.php'; ?>
<?php require 'nav.php'; ?>
<?php
if(!isset($_SESSION['username']))
{
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
        $url = "https://";   
    else     
        $url = "http://";   
    $url.= $_SERVER['HTTP_HOST'];   
    $url.= $_SERVER['REQUEST_URI'];    
    $_SESSION['back']=$url;
    header('Location:'.'signin.php');
}
$uname=$_SESSION['username'];
$accountid=$_SESSION['accountid'];
$pid=$_GET['pid'];
$qty=$_GET["qty"];

$sql="SELECT * from grocerycatalog where id=$pid;";
$result=$conn->query($sql);
$row = $result->fetch_assoc();
$name=$row["name"];
$price=$row["price"];
$amount=$qty*$price;

$sql="insert into payments(payment_amount,qty,payment_status,itemid,page,custid,createdtime) values($amount,$qty,'Completed',$pid,'grocery',$accountid,'".date('Y-m-d H:i:s')."');";
$conn->query($sql);

$sql="insert into orders(custid,productid,qty,price,total,page,orderfrom,date) values($accountid,$pid,$qty,$price,$amount,'grocery','direct','".date('Y-m-d H:i:s')."');";
$conn->query($sql);

$sql="SELECT * from customer where id=$accountid;";
$result=$conn->query($sql);
$row = $result->fetch_assoc();
//$email=$row["emailid"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paypal Integration Test</title>
</head>
<body>

    <form class="paypal" action="payments.php" method="post" id="paypal_form" name="myform">
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="no_note" value="1" />
        <input type="hidden" name="lc" value="UK" />
        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
        <input type="hidden" name="first_name" value="<?php echo $uname; ?>" />
        <input type="hidden" name="last_name" value="" />
        <input type="hidden" name="payer_email" value="<?php echo $email; ?>" />
        <input type="hidden" name="item_name" value="<?php echo $name; ?>" />
        <input type="hidden" name="item_number" value="<?php echo $pid; ?>" />
        <input type="hidden" name="item_qty" value="<?php echo $qty; ?>" />
        <input type="hidden" name="item_amount" value="<?php echo $amount; ?>" />
        <input type="hidden" name="custid" value="<?php echo $accountid; ?>" />
        <input type="submit" hidden/>
    </form>
<script>
window.onload = function(){
    document.forms['myform'].submit();
}
</script>
</body>
</html>