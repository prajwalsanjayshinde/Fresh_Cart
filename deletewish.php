<?php require 'config.php' ?>
<?php
    session_start();
    $id=$_GET['id'];
    $sql="delete from grocerywishlist where pid=$id and custid=".$_SESSION['accountid'];
    $conn->query($sql);
    //header('Location:'.'cart.php');
?>