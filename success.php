<h1>Your payment has been successful.</h1>
<?php
error_reporting(1);
require 'config.php';
//Store transaction information into database from PayPal
$item_number =$_POST['item_number']; 
$txn_id =$_POST['txn_id'];
$payment_gross =$_POST['mc_gross'];
$currency_code =$_POST['mc_currency'];
$payment_status =$_POST['payment_status'];
//Get product price to store into database
echo isset($_POST["txn_id"]);
$sql = "SELECT * FROM products WHERE id = ".$item_number;
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
$row = mysqli_fetch_assoc($resultset);
if(!empty($txn_id) && $payment_gross == $row['price']){
    //Insert tansaction data into the database
    mysqli_query($conn, "INSERT INTO payments(item_number,txn_id,payment_gross,currency_code,payment_status) VALUES('".$item_number."','".$txn_id."','".$payment_gross."','".$currency_code."','".$payment_status."')");
	$last_insert_id = mysqli_insert_id($conn);  
	
?>
	<h1>Your payment has been successful.</h1>
    <h1>Your Payment ID - <?php echo $last_insert_id; ?>.</h1>
<?php
}else{
?>
	<h1>Your payment has failed.</h1>
<?php
}
?>