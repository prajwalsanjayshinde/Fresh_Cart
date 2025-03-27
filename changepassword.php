<?php
    include("config.php");
    $answer=mysqli_real_escape_string($conn,$_POST['secanswer']);
    $str=mysqli_real_escape_string($conn,$_POST['uname']);
    $sql = "select secanswer from account where username='$str';";
    $result=$conn->query($sql);
      if (mysqli_num_rows($result) == 0) 
      { // IF no previous user is using this username.
        header("Location: questions.php?uname=$str&err=2");
      }
    $row = $result->fetch_assoc();
    if($row['secanswer']!=$answer)
    {
        header("Location: questions.php?uname=$str&err=1");
    }
    else
    {
    $password=hash('sha256',mysqli_real_escape_string($conn,$_POST['pass1']));
    $sql = "select * from account where username='$str';";
    $sql=$sql = "UPDATE account SET password='".$password."' WHERE username='".$str."';";
    $result=$conn->query($sql);
    header("Location: signin.php?uname=$str");
    }
?>