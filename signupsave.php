<?php
    if (isset($_SESSION['username'])) {
        header('Location:'.'index.php');
    }
    ?>
<?php
    include("config.php");

    //User details are taken from the $_POST 
    $name=mysqli_real_escape_string($conn,$_POST['cname']);
    $contactno=mysqli_real_escape_string($conn,$_POST['phone']);
    $email=mysqli_real_escape_string($conn,$_POST['emailid']);
    $address=mysqli_real_escape_string($conn,$_POST['address']);
    $username=mysqli_real_escape_string($conn,$_POST['uname']);
    $secquestion=mysqli_real_escape_string($conn,$_POST['secquestion']);
    $secanswer=mysqli_real_escape_string($conn,$_POST['secanswer']);
    $password=hash('sha256',mysqli_real_escape_string($conn,$_POST['password']));

    // Data collected from form is inserted in Customer table
    $sql = "INSERT INTO customer (name,phoneno,emailid,address)VALUES ('$name', $contactno,'$email','$address')";
    if ($conn->query($sql) === TRUE) {
        echo "New Customer created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //This query returns the last id which is the latest record
    $sql="SELECT id FROM customer ORDER BY id DESC LIMIT 1;";
    $result=$conn->query($sql);
    $row = $result->fetch_assoc();
    $id=$row['id'];

    //This query enters login details of customer in Account table
    $sql = "INSERT INTO account (username,password,custid,secquestion,secanswer)VALUES ('$username','$password',$id,'$secquestion','$secanswer')";
    if ($conn->query($sql) === TRUE) {
        echo "New Account created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
    header("Location: signin.php?uname=$username&password=$password");
?>