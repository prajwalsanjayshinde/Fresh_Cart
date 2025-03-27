<?php require 'nav.php' ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/formoid-flat-green.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="hero-image">
    </div>
    <!-- Nav bar -->

    <?php
    if (isset($_SESSION['username'])) {
        header('Location:' . 'index.php');
    }
    ?>
    <!-- Nav bar finishh -->
    <!-- Inspection form start -->
    <section>
        <div class="container">
            <form enctype="multipart/form-data" class="formoid-flat-green" style="background-color:#fff;font-size:14px;font-family:'Lato', sans-serif;color:#000;max-width:600px;min-width:150px" method="post" action="signupsave.php" name="myForm">
                <div class="title">
                    <h2>SignUp Form</h2>
                </div>
                <div class="element-separator">
                    <hr>
                    <h3 class="section-break-title">Customer Details</h3>
                </div>


                <div class="element-name">
                    <span class="mid1"> <label class="title">Your Username</label> <input type="text" size="8" name="uname" id="uname" required="required" onkeyup="checkUsername(this.value)" />
                        <label class="subtitle" style="color:red;" id="errMsg"></label>
                    </span>
                    <span class="mid1"> <label class="title">Your Name</label> <input type="text" size="8" name="cname" id="cname" required="required" /> </span>
                    <span class="mid1"> <label class="title">Email ID</label> <input type="email" size="20" name="emailid" id="emailid" required="required" /> </span>
                    <span class="mid1"> <label class="title">Phone Number</label> <input type="number" size="10" name="phone" id="phone" required="required" /> </span>
                    
                    <span class="mid1"> <label class="title">Your Password</label> <input type="password" name="password" id="password" /> </span>
                    <span class="mid1"> <label class="title">Confirm Your Password</label> <input type="password" name="cpassword" id="cpassword"/> </span>
                    <label class="subtitle" style="color:red;" id="errPass"></label>
                    <span class="mid1"> <label class="title">Choose Security Question</label> 
                    <select name="secquestion" required>
                    <option value="Name of favorite Teacher?">Name of favorite Teacher?</option>
                    <option value="Name of primary School?">Name of primary School?</option>
                    <option value="Name of Birthplace?">Name of Birthplace?</option>
                    </select>
                    </span>
                    <span class="mid1"> <label class="title">Enter answer for security question:</label> 
                    <input type="password" name="secanswer" id="password" required/> </span>

                    <label class="title">Address</label> <textarea rows="4" cols="50" name="address" id="address"></textarea>
                    <label class="subtitle" style="color:red;" id="errPhone"></label>
                </div>


                <div class="submit"><input type="submit" value="Submit" onclick="return check();" /></div>
            </form>
    </section>
    <!-- inspection section finish -->
    <!-- footer section -->
    <footer class="center">
        <p style="color:white">Some Text here<br> <a href="mailto:hege@example.com" style="color:white">EMAIL US</a>
    </footer>
    <!-- footer section finish -->
    </div>
</body>

<script type="text/javascript" language="javascript">
    //this function takes username entered by the user as argument and
    //checks wether that username is available
    function checkUsername(str) {
        if (str.length != 0) {
            var xmlhttp = new XMLHttpRequest();
            //when the open() function state is changed this function is called
            xmlhttp.onreadystatechange = function() {
                //checks if the open() function state is changed to complete
                if (this.readyState == 4 && this.status == 200) {
                    allowed = (this.responseText); // stores answer returned by open function
                    if (allowed == 0)
                        document.getElementById("errMsg").innerHTML = "Username taken";
                    else
                        document.getElementById("errMsg").innerHTML = "";
                }
            };
            // the username entered by the user is sent to the php script as a querystring
            xmlhttp.open("GET", "getusername.php?q=" + str, true);
            xmlhttp.send();
        }
    }

    function check() {
        //if the username is not available than the user is not allowed to submit
        document.getElementById("errPhone").innerHTML="";
        if (allowed == 0)
            return false;
        var ans=1;
        var name = document.getElementById('cname').value;
        var uname = document.getElementById('uname').value;
        var emailid = document.getElementById('emailid').value;
        var phone = document.getElementById('phone').value;
        var password = document.getElementById('password').value;
        var cpassword = document.getElementById('cpassword').value;
        var address = document.getElementById('address').value;
        if (phone.length != 10) {
            document.getElementById("errPhone").innerHTML = "Phone number invalid!";
            ans=0;
        } 
        if (password.length <= 8) {
            document.getElementById("errPhone").innerHTML += "<br>";
            document.getElementById("errPhone").innerHTML += "Password length should be greater than 8!";
            ans=0;
        } 
        if (password!=cpassword) {
            document.getElementById("errPhone").innerHTML += "<br>";
            document.getElementById("errPhone").innerHTML += "Passwords don't match!";
            ans=0;
        }
        if(ans==1)
        {
            return true;
        } 
        return false;
    }
</script>

</html>
