<?php
    $name=$_GET['name'];
    $pid=$_GET['pid'];
    $price=$_GET['price'];
?>
<body onload="submitForm()">
<form method="post" action="payments.php" id="myForm">
    <input type="hidden" name="name" value="<?php echo $_GET['name']; ?>">
    <input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>">
    <input type="hidden" name="item_name" value="<?php echo $_GET['name']; ?>">
    <input type="hidden" name="item_number" value="<?php echo $_GET['pid']; ?>">
    <input type="hidden" name="price" value="<?php echo $_GET['price']; ?>">
    <input type="hidden" name="cmd" value="_xclick" />
    <input type="hidden" name="no_note" value="1" />
    <input type="hidden" name="lc" value="UK" />
    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
    <input type="hidden" name="first_name" value="Customer's First Name" />
    <input type="hidden" name="last_name" value="Customer's Last Name" />
    <input type="hidden" name="payer_email" value="customer@example.com" />
    <input type="submit" hidden>
</form>

<script type="text/javascript" language="javascript">
    function submitForm()
    {
        document.getElementById("myForm").submit();
    }
</script>
</body>