<?php require 'config.php'; ?>
<?php
    $qty=1;
    $accountid=2;
    $pid=2;
    $price=3;
    $amount=4;
    $sql="insert into orders(custid,productid,qty,price,total,page,orderfrom,date) values($accountid,$pid,$qty,$price,$amount,'mask','direct','".date('Y-m-d H:i:s')."');";
    echo $conn->query($sql);
?>