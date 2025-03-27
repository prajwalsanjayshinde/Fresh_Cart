<?php
    if (isset($_SESSION['username'])) {
        header('Location:'.'index.php');
    }
    ?>
<?php
    include("config.php");

    //User details are taken from the $_POST 
    $answer=mysqli_real_escape_string($conn,$_POST['answer']);
    $sql = "select secanswer from account where username='$str';";
    $result=$conn->query($sql);
    if($result->secanswer===$answer)
    {
        header('Location:'.'newpassword.php');
    }
?>