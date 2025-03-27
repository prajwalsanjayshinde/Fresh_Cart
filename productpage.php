<?php require 'nav.php' ?>
<?php require 'config.php' ?>
<?php
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
    if(empty($_GET['id']) || empty($_GET['qty']))
    {
        header('Location:'.'catalogue.php');
    }
    $qty=$_GET['qty'];
    $pid=$_GET['id'];
    $sql="SELECT * from grocerycatalog where id=$pid;";
    $result=$conn->query($sql);
    $row = $result->fetch_assoc();
    $name=$row["name"];
    $price=$row["price"];
    $accountid=$_SESSION['accountid'];
    if($row["category"]==0)
    {
        $category="Essential Items";
    }
    else if($row["category"]==1)
    {
        $category="Grocery Items";
    }
    else
    {
        $category="Dairy Items";
    }
    $description=$row["description"];
    $imgname="images/products/".$row['imagename'];
    $sql = "select pid from grocerywishlist where custid=$accountid";
    $result = $conn->query($sql);
    $wishes=array();
    while( $row = mysqli_fetch_assoc( $result)){
        array_push($wishes,$row['pid']);
    }
?>
<html>
    <head>
    <link rel="stylesheet" href="css/productpage.css" type="text/css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    </head>
    <body>
    <div hidden><img src="images/icons/wish.png" id="wishtemp"></div>
    <div hidden><img src="images/icons/wishempty.png" id="unwishtemp"></div>
        <div class="prodbody">
            <div class="prodimage">
                <img src="<?php echo $imgname; ?>">
            </div>
            <div class="prodinfo">
                <div class="prodcategory">/<?php echo $category; ?>
                <?php
                if(in_array($pid,$wishes))
                    {
                        print <<< END
                        <div class="productwish" onclick="removeWish(this,$pid)"><img src="images/icons/wish.png"></div>
END; 
                    }
                    else
                    {
                        print <<< END
                        <div class="productwish" onclick="addWish(this,$pid)"><img src="images/icons/wishempty.png"></div>
END; 
                    }
                    ?>
                </div>
                <div class="prodtitle"><?php echo $name; ?></div>
                <div class="prodprice">$ <?php echo $price; ?></div>
                <div id="price" hidden><?php echo $price; ?></div>
                <div class="qty">
                    <div class="qtybtn" onclick="subQty()">-</div>
                    <input type="number" name="qty" value="<?php echo $qty ?>" id="qty" readonly>
                    <div class="qtybtn" onclick="addQty()">+</div>
                </div>
                <div class="totaldiv">
                    <div class="total">Total: $ </div>
                    <div id="dprice" class="totalprice"><?php echo $price*$qty; ?></div>
                </div>
                <?php $pname="'".$name."'";?>
                <div class="buybutton" onclick="buy(<?php echo $pid.','.$pname.','.$price*$qty; ?>)""><img src="images/icons/buy.png" height="24px" weight="24px">   Buy Now</div>
                <div class="buybutton" onclick="addCart(<?php echo $pid; ?>)"><img src="images/icons/cart.png" height="25px" weight="25px">  Add to Cart</div>
                <div class="buyfeatures">
                    <div class="feature">3 Days Delivery</div>
                    <div class="feature">Fresh Items</div>
                    <div class="feature">24/7 Customer Support</div>
                </div>
                <div class="prodabout">
                    <div class="prodheads">About this Item:</div>
                    <div class="proddesc"><?php echo $description; ?></div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        function addQty()
        {
            var qty=parseInt(document.getElementById("qty").value);
            document.getElementById("qty").value=qty+1;
            var price=parseFloat(document.getElementById("price").innerHTML);
            document.getElementById("dprice").innerHTML=(qty+1)*price;
        }
        function subQty()
        {
            var qty=parseInt(document.getElementById("qty").value);
            if(qty==1)
            {
                return;
            }
            document.getElementById("qty").value=qty-1;
            var price=parseFloat(document.getElementById("price").innerHTML);
            document.getElementById("dprice").innerHTML=(qty-1)*price;
        }
        function buy(pid,name,price)
        {
            var qty=parseInt(document.getElementById("qty").value);
            window.location.replace("buyitem.php?pid="+pid+"&qty="+qty);
        }
        function addCart(pid)
        {
            var qty=document.getElementById("qty").value;
            window.location.replace("addtocart.php?id="+pid+"&qty="+qty);
        }
        function addWish(current,pid)
        {
            var newEl=document.getElementById("wishtemp").cloneNode(true);
            current.children[0].replaceWith(newEl);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "addwishlist.php?pid=" + pid, true);
            xmlhttp.send();
        }
        function removeWish(current,pid)
        {
            var newEl=document.getElementById("unwishtemp").cloneNode(true);
            current.children[0].replaceWith(newEl);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "deletewish.php?id=" + pid, true);
            xmlhttp.send();
        }
    </script>
</html>