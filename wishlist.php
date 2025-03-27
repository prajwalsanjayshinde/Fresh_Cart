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
    $sql="select cat.id as prodid,cat.name as name,cat.price as price,cat.imagename as img,car.id as id from grocerywishlist as car left join grocerycatalog as cat on car.pid=cat.id where car.custid=$accountid;";
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
                    <div class="delete" onclick="deleteWish($id,$prodid)"><img src="images/icons/delete.png"></div>
                </div>
                <div class="row">
                    <div class="price">$<label id="$idd" class="dprice">$price</label></div>
                </div>
                <div class="row">
                    <div class="buybtn" onclick="view($prodid)">View</div>
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
        </div>  
    </body>
    <script type="text/javascript">
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
        function view(id)
        {
            window.location.replace("productpage.php?id="+id+"&qty=1");
        }
        function deleteWish(pid,id)
        {
            var obj=document.getElementById(pid);
            obj.remove();
            var count=parseFloat(document.getElementById("itemcount").innerHTML);
            document.getElementById("itemcount").innerHTML=count-1;
            calcTotal();
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","deletewish.php?id="+id, true);
            xmlhttp.send();
            //window.location.replace("deletecart.php?id="+pid);
        }
    </script>
</html>