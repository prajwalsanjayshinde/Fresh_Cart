<?php require 'nav.php' ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/formoid-flat-green.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="hero-image">

    <section>
        <div class="container center">
            <form enctype="multipart/form-data" class="formoid-flat-green" style="background-color:#E4E4F4;font-size:14px;font-family:'Lato', sans-serif;color:#000;max-width:600px;min-width:150px" method="post" action="additemback.php">
                <div class="title">
                    <h2 style="margin-right: 27px;margin-left: 27px;">Add Item</h2>
                </div>
                <div lass="element-name">
                    <label class="title">Name</label> <input type="text" name="mname" required="required" style="width:50%;" /><br>
                    <label class="title">Price</label> <input type="text" name="price" required="required" style="width:50%;" /><br>
                    <label class="title">Category</label>
                    <span class="mid1">
                    <select name="category" style="width:50%;">
                        <option value="0" selected>Essentials</option>
                        <option value="1">Grocery</option>
                        <option value="2">Dairy Products</option>
                    </select>
                    </span><br>
                    <label class="title">Description</label> <input type="text" name="description" required="required" style="width:50%;" /><br>
                    <label class="title">Select Image</label>
                    <input type="file" name="fileToUpload" id="fileToUpload" style="width:50%;">
                   
                </div>
                <div class="submit"><input type="submit" value="Submit" /></div>
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

</html>