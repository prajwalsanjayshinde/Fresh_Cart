<?php
$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; 
$paypal_email = 'sb-jjs645499947@business.example.com';
?>
<html>
    <body>
    <form action="<?php echo $paypal_url; ?>" method="post">			
        <!-- Paypal business test account email id so that you can collect the payments. -->
        <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">			
        <!-- Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">			
        <!-- Details about the item that buyers will purchase. -->
        <input type="hidden" name="item_name" value="<?php echo "eggs"; ?>">
        <input type="hidden" name="item_number" value="<?php echo "2"; ?>">
        <input type="hidden" name="amount" value="<?php echo "20"; ?>">
            <input type="hidden" name="currency_code" value="USD">			
        <!-- URLs -->
        <input type='hidden' name='cancel_return' value='http://localhost:8081/Grocery/GroceryStore/cancel.php'>
        <input type='hidden' name='return' value='http://localhost:8081/Grocery/GroceryStore/success.php'>						
        <!-- payment button. -->
        <input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
        <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >    
    </form>
    </body>
</html>