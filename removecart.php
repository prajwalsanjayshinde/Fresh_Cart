<?php require 'config.php' ?>
<?php
    session_start();
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
    if(!isset($_GET['pid']))
    {
        header('Location:'.'catalogue.php');
    }
    $accountid=$_SESSION['accountid'];
    $pid=$_GET['pid'];
    $qty=$_GET['qty'];
    $sql="update grocerycart set qty=$qty,total=price*$qty where productid=$pid and accountid=$accountid";
    $conn->query($sql);;
    if($conn->query($sql)===TRUE)
    {
        //header('Location:'.'cart.php');
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    ?>
    