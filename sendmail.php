<?php require 'nav.php'; ?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'config.php';
require_once "vendor/autoload.php";

$target_dir = "images/mails/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}
}

// Check if file already exists
if (file_exists($target_file)) {
echo "Sorry, file already exists.";
$uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
echo "Sorry, your file is too large.";
$uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
$uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}
}
$imgname=basename($_FILES["fileToUpload"]["name"]);


$priority=$_POST['priority'];
$sql="select * from customer where priority=$priority;";
$result=$conn->query($sql);

while($row = $result->fetch_assoc()) {
    $mail = new PHPMailer(true);
    //$mail->SMTPDebug = 3;                               
    $mail->isSMTP();            
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;             
    $mail->Username = "emailid@gmail.com";                 
    $mail->Password = "password";         
    $mail->addReplyTo('noreply@gmail.com', 'No Reply');                  
    $mail->SMTPSecure = "tls";                           
    $mail->Port = 587;                                   
    $mail->From = "emailid@gmail.com";
    $mail->FromName = "Mask Store";
    $mail->addAddress($row["emailid"], $row["name"]);   
    $mail->isHTML(true);
    $mail->Subject = $_POST["subject"];
    
    $name=$row["name"];
    $mail->AddEmbeddedImage('images/mails/'.$imgname, 'photo', $imgname); 
    $mail->Body = "<h2>Special Discounts for you!</h2><h3>Hey $name!</h3><h4>Discount of :".$_POST['discount']."</h4>".$_POST["description"]." Visit our store: https://mygrocerystorephp.herokuapp.com <br>"."<img src='cid:photo'>"; 
    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}



//$mail->AltBody = "This is the plain text version of the email content";

try {
    $mail->send();
    echo "Message has been sent successfully";

} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}