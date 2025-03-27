<?php require 'nav.php' ?>
<?php
if (isset($_SESSION['username'])) {
    header('Location:' . 'index.php');
}
?>
<?php
include("config.php");

//User details are taken from the $_POST 
$str = mysqli_real_escape_string($conn, $_GET['uname']);
$sql = "select * from account where username='$str';";
$result = $conn->query($sql);
if (mysqli_num_rows($result) == 0) 
      { // IF no previous user is using this username.
        header("Location: forgotpasswordfront.php?err=2");
      }
$row = $result->fetch_assoc();
if (isset($_GET['err'])) {
    if ($_GET['err'] == 1) {
        echo "<script>alert('Security Answer Incorrecct!');</script>";
    }
    if ($_GET['err'] == 2) {
        echo "<script>alert('Username does not exist!');</script>";
    }
}
?>
<html>

<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/formoid-flat-green.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <section>
        <div class="container center">
            <form enctype="multipart/form-data" class="formoid-flat-green" style="background-color:#fff;font-size:14px;font-family:'Lato', sans-serif;color:#000;max-width:600px;min-width:150px" method="post" action="changepassword.php">
                <div class="title">
                    <h2 style="margin-right: 27px;margin-left: 27px;">New Password</h2>
                </div>
                <div lass="element-name">
                    <label class="title">Username: </label>
                    <input type="text" name="uname" value=<?php echo $row['username']; ?> required="required" />
                    <label class="title"><?php echo $row['secquestion']; ?></label> <input type="password" name="secanswer" required="required" />
                    <label class="title">New Password:</label> <input type="password" name="pass1" id="pass1" required="required" />
                    <label class="title">Write Password Again:</label> <input type="password" name="pass2" id="pass2" required="required" />
                    <label class="subtitle" style="color:red;" id="errPass"></label>
                    <h3><label class="subtitle" style="color:black;"><a href="signup.php">New user? Sign up!</a></label></h3>
                </div>
                <div class="submit"><input type="submit" value="Submit" onclick=" return validate();" /></div>
            </form>
    </section>
</body>
<script type="text/javascript" language="javascript">
    function validate() {
        document.getElementById("errPass").innerHTML="";
        ans=1;
        var pass1=document.getElementById('pass1').value;
        var pass2=document.getElementById('pass2').value;
        document.getElementById("errPass").innerHTML += "";
        if (pass1.length <= 8) {
            document.getElementById("errPass").innerHTML += "<br>";
            document.getElementById("errPass").innerHTML += "Password length should be greater than 8!";
            ans = 0;
        }
        if (pass1 != pass2) {
            document.getElementById("errPass").innerHTML += "<br>";
            document.getElementById("errPass").innerHTML += "Passwords don't match!";
            ans = 0;
        }
        if (ans == 1) {
            return true;
        }
        return false;
    }
</script>

</html>
