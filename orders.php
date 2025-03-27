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
    $sql="select car.id as prodid,car.date as date,cat.name as name,cat.price as price,cat.imagename as img,car.id as id,car.qty as qty,car.total as total from orders as car left join grocerycatalog as cat on car.productid=cat.id and car.custid=$accountid where car.orderfrom='direct' and page='grocery' and car.custid=$accountid;";
    $result=$conn->query($sql);

    $sql="select car.id as prodid,car.date as date,cat.name as name,cat.price as price,cat.imagename as img,car.id as id,car.qty as qty,car.total as total from orders as car left join grocerycart as cart on car.productid=cart.id left join grocerycatalog as cat on cart.productid=cat.id and car.custid=$accountid where car.orderfrom='cart' and page='grocery' and car.custid=$accountid;";
    $result2=$conn->query($sql);

    $noitems=$result->num_rows+$result2->num_rows;
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
            $date=$row['date'];
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
            <div class="item">
            <div class="left">
                <img src="images/products/$img">
            </div>
            <div id="$idprod" hidden>$prodid</div>
            <div class="right">
                <div class="row">
                    <div class="name">$name</div>
                    <label class="name">$date</label>
                </div>
                <div id="$idp" hidden>$price</div>
                <div class="row">
                    <div class="price">$<label id="$idd" class="dprice">$total</label></div>
                    <div class="qtydiv">
                        <div class="qty">
                            <input type="number" name="qty" value="$qty" id="$idq" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
END;
        } 
        while($row = $result2->fetch_assoc()) 
        {
            $name=$row['name'];
            $date=$row['date'];
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
            <div class="item">
            <div class="left">
                <img src="images/products/$img">
            </div>
            <div id="$idprod" hidden>$prodid</div>
            <div class="right">
                <div class="row">
                    <div class="name">$name</div>
                    <label class="name">$date</label>
                </div>
                <div id="$idp" hidden>$price</div>
                <div class="row">
                    <div class="price">$<label id="$idd" class="dprice">$total</label></div>
                    <div class="qtydiv">
                        <div class="qty">
                            <input type="number" name="qty" value="$qty" id="$idq" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
END;
        }
?>
        </div>
        <div class="totaldiv">
            <div class="row">
                <div class="noitems">Number of Items: <label><?php echo $noitems; ?></label></div>
            </div>
            <div class="row">
                <div class="grandtotal">Grand Total: <label>$</label><label id="gtotal"></label></div>
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
            window.location.replace("addcart.php?id="+pid+"&qty=1");
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
            window.location.replace("removecart.php?pid="+pid+"&qty="+(qty-1));
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
            window.location.replace("deletecart.php?id="+pid);
        }
    </script>
</html>