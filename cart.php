<?php require 'config.php' ?>
<?php require 'nav.php' ?>
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
    $accountid=$_SESSION['accountid'];
    $sql="select cat.id as prodid,cat.name as name,cat.price as price,cat.imagename as img,car.id as id,car.qty as qty,car.total as total from grocerycart as car left join grocerycatalog as cat on car.productid=cat.id and car.accountid=$accountid where car.status='Added to Cart' and car.accountid=$accountid;";
    $result=$conn->query($sql);
    $noitems=$result->num_rows;
?>

<html>
    <head>
        <link rel="stylesheet" href="css/cart.css" type="text/css" />
    </head>
    <body onload="calcTotal()">
        <div class="allitems">
        <?php
        while($row = $result->fetch_assoc()) 
        {
            $name=$row['name'];
            $img=$row['img'];
            $id=$row['id'];
            $prodid=$row['id'];
            $price=$row['price'];
            $qty=$row['qty'];
            $total=$row['total'];
            $prodid=$row['prodid'];
            $idq=$id."qty";
            $idp=$id."price";
            $idd=$id."dprice";
            $idprod=$id."prod";
            print <<< END
            <div class="item" id="$id">
            <div class="left">
                <img src="images/products/$img">
            </div>
            <div id="$idprod" hidden>$prodid</div>
            <div class="right">
                <div class="row">
                    <div class="name">$name</div>
                    <div class="delete" onclick="deleteCart($id)"><img src="images/icons/delete.png"></div>
                </div>
                <div id="$idp" hidden>$price</div>
                <div class="row">
                    <div class="price">$<label id="$idd" class="dprice">$total</label></div>
                    <div class="qtydiv">
                        <div class="qty">
                            <div class="qtybtn" onclick="subQty($id)">-</div>
                            <input type="number" name="qty" value="$qty" id="$idq" readonly>
                            <div class="qtybtn" onclick="addQty($id)">+</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="buybtn" onclick="buy($id)">BUY</div>
                </div>
            </div>
        </div>
END;
        } ?>
        </div>
        <div class="totaldiv">
            <div class="row">
                <div class="noitems">Number of Items: <label id="itemcount"><?php echo $noitems; ?></label></div>
            </div>
            <div class="row">
                <div class="grandtotal">Grand Total: <label>$</label><label id="gtotal"></label></div>
            </div>
            <div class="row">
                <div class="buybtn" onclick="buyall()">BUY ALL</div>
            </div>
        </div>  
    </body>
    <script type="text/javascript">
        function addQty(id)
        {
            var qty=parseInt(document.getElementById(id+"qty").value);
            document.getElementById(id+"qty").value=qty+1;
            var price=parseFloat(document.getElementById(id+"price").innerHTML);
            document.getElementById(id+"dprice").innerHTML=(qty+1)*price;
            calcTotal();
            pid=document.getElementById(id+"prod").innerHTML;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","addcart.php?id="+pid+"&qty=1", true);
            xmlhttp.send();
            //window.location.replace("addcart.php?id="+pid+"&qty=1");
        }
        function subQty(id)
        {
            var qty=parseInt(document.getElementById(id+"qty").value);
            if(qty<=1)
            {
                return;
            }
            document.getElementById(id+"qty").value=qty-1;
            var price=parseFloat(document.getElementById(id+"price").innerHTML);
            document.getElementById(id+"dprice").innerHTML=(qty-1)*price;
            calcTotal();
            pid=document.getElementById(id+"prod").innerHTML;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","removecart.php?pid="+pid+"&qty="+(qty-1), true);
            xmlhttp.send();
            //window.location.replace("removecart.php?pid="+pid+"&qty="+(qty-1));
        }
        function calcTotal()
        {
            var x = document.getElementsByClassName("dprice");
            var i;
            var total=0;
            for (i = 0; i < x.length; i++) {
                total+=parseFloat(x[i].innerHTML);
            }
            document.getElementById("gtotal").innerHTML=total;
        }
        function buy(id)
        {
            window.location.replace("buyitemfromcart.php?id="+id);
        }
        function buyall()
        {
            window.location.replace("buycart.php");
        }
        function deleteCart(pid)
        {
            var obj=document.getElementById(pid);
            obj.remove();
            var count=parseFloat(document.getElementById("itemcount").innerHTML);
            document.getElementById("itemcount").innerHTML=count-1;
            calcTotal();
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","deletecart.php?id="+pid, true);
            xmlhttp.send();
            //window.location.replace("deletecart.php?id="+pid);
        }
    </script>
</html>