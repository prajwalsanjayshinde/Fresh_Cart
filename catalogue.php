<?php require 'nav.php' ?>
<?php require 'config.php' ?>
<?php
if(isset($_SESSION['username']))
{
    $accountid=$_SESSION['accountid'];
    $sql = "select pid from grocerywishlist where custid=$accountid";
    $result = $conn->query($sql);
    $wishes=array();
    while( $row = mysqli_fetch_assoc( $result)){
        array_push($wishes,$row['pid']);
    }
}   
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/formoid-flat-green.css" type="text/css" />
    <link rel="stylesheet" href="css/catalogue.css" type="text/css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body class="hero-image" onload="showEssentials()">
    <div class="search-container">
      <input type="text" placeholder="Search.." id="searchval" name="search" class="searchbox" >
      <button type="submit" class="srcbutton" onclick="search()"><i class="fa fa-search"></i></button>
  </div>

    <div class="maindiv">
    <div class="sectionchoosediv">
        <div class="sectiondiv" style="cursor: pointer;" onclick="showEssentials()">
            <img src="images/packedfoodsection.png" class="sectionicon">
            <div class="sectionname" style="cursor: pointer;" onclick="showEssentials()">
                Essentials
            </div>
        </div>
        <div class="sectiondiv" style="cursor: pointer;" onclick="showGrocery()">
            <img src="images/vegetablessection.png" class="sectionicon">
            <div class="sectionname" style="cursor: pointer;" onclick="showGrocery()">
                Grocery
            </div>
        </div>
        <div class="sectiondiv" style="cursor: pointer;" onclick="showDairy()">
            <img src="images/milksection.png" class="sectionicon" style="cursor: pointer;" onclick="showDairy()">
            <div class="sectionname">
                Dairy Products
            </div>
        </div>
    </div>
    <div hidden><img src="images/icons/wish.png" id="wishtemp"></div>
    <div hidden><img src="images/icons/wishempty.png" id="unwishtemp"></div>
    <div class="allproductdiv">

    <div id="showing">
    </div>
        <div class="productrowdiv" id="searchitem">
        
        </div>
        <div class="productrowdiv" id="essentials">

        <?php
            $sql = "SELECT id,name,price,imagename FROM grocerycatalog where category=0";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $imgname="images/products/".$row['imagename'];
                    $name=$row['name'];
                    $price=$row['price'];
                    $link="productpage.php?id=".$row['id']."&qty=1";
                    $id=$row['id'];
                    print <<< END
                    <div class="productdivtop">
                    <div class="productdiv">
                    <label class="productid" hidden>$id</label>
END;                   
                    if(isset($wishes))
                    {
                    if(in_array($id,$wishes))
                    {
                        print <<< END
                        <div class="productwish" onclick="removeWish(this,$id)"><img src="images/icons/wish.png"></div>
END; 
                    }
                    else
                    {
                        print <<< END
                        <div class="productwish" onclick="addWish(this,$id)"><img src="images/icons/wishempty.png"></div>
END; 
                    }
                }
                else
                {
                    print <<< END
                    <div hidden></div>
END;
                }
                    print <<< END
                    <img src="$imgname" class="productimage">
                    <div class="productname">$name</div>
                    <div class="productprice">$ $price</div>
                    <a href="$link" class="productbutton"><div>+ Cart</div></a>
                    </div>
                    </div>
END;
                }
            }
        ?>
            
        </div>



        <div class="productrowdiv" id="grocery">
        <?php
            $sql = "SELECT id,name,price,imagename FROM grocerycatalog where category=1";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $imgname="images/products/".$row['imagename'];
                    $name=$row['name'];
                    $price=$row['price'];
                    $link="productpage.php?id=".$row['id']."&qty=1";
                    $id=$row['id'];
                    print <<< END
                    <div class="productdivtop">
                    <div class="productdiv">
                    <label class="productid" hidden>$id</label>
                    END;
                    if(isset($wishes))                   
                    {
                    if(in_array($id,$wishes))
                    {
                        print <<< END
                        <div class="productwish" onclick="removeWish(this,$id)"><img src="images/icons/wish.png"></div>
END; 
                    }
                    else
                    {
                        print <<< END
                        <div class="productwish" onclick="addWish(this,$id)"><img src="images/icons/wishempty.png"></div>
END; 
                    }
                }
                else
                {
                    print <<< END
                    <div hidden></div>
END;
                }
                    print <<< END
                    <img src="$imgname" class="productimage">
                    <div class="productname">$name</div>
                    <div class="productprice">$ $price</div>
                    <a href="$link" class="productbutton"><div>+ Cart</div></a>
                    </div>
                    </div>
END;
                }
            }
        ?>
        
        </div>


        <div class="productrowdiv" id="dairy">
        <?php
            $sql = "SELECT id,name,price,imagename FROM grocerycatalog where category=2";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $imgname="images/products/".$row['imagename'];
                    $name=$row['name'];
                    $price=$row['price'];
                    $link="productpage.php?id=".$row['id']."&qty=1";
                    $id=$row['id'];
                    print <<< END
                    <div class="productdivtop">
                    <div class="productdiv">
                    <label class="productid" hidden>$id</label>
                    END;  
                    if(isset($wishes)) 
                    {                
                    if(in_array($id,$wishes))
                    {
                        print <<< END
                        <div class="productwish" onclick="removeWish(this,$id)"><img src="images/icons/wish.png"></div>
END; 
                    }
                    else
                    {
                        print <<< END
                        <div class="productwish" onclick="addWish(this,$id)"><img src="images/icons/wishempty.png"></div>
END; 
                    }
                }
                else
                {
                    print <<< END
                    <div hidden></div>
END;
                }
                    print <<< END
                    <img src="$imgname" class="productimage">
                    <div class="productname">$name</div>
                    <div class="productprice">$ $price</div>
                    <a href="$link" class="productbutton"><div>+ Cart</div></a>
                    </div>
                    </div>
END;
                }
            }
        ?>
        
        </div>
    </div>
    </div>
</body>

<script type="text/javascript" language="javascript">

        document.getElementById("essentials").style.visibility="hidden";
        document.getElementById("grocery").style.visibility="hidden";
        document.getElementById("dairy").style.visibility="hidden";
        document.getElementById("searchitem").style.visibility="hidden";
    function showGrocery()
    {
        document.getElementById("showing").innerHTML=document.getElementById("grocery").innerHTML;
    }
    function showDairy()
    {
        document.getElementById("showing").innerHTML=document.getElementById("dairy").innerHTML;
    }
    function showEssentials()
    {
        document.getElementById("showing").innerHTML=document.getElementById("essentials").innerHTML;
    }
    function search()
    {
        var src= document.getElementById("searchval").value;
        var products= document.getElementsByClassName("productdivtop");
        var temp;
        document.getElementById("showing").innerHTML="";
        document.getElementById("searchitem").innerHTML="";
        for(var i=0;i<products.length;i++)
        {
            if(products[i].children[0].children[3].innerHTML.toUpperCase().includes(src.toUpperCase()))
            {        
                document.getElementById("searchitem").innerHTML+=products[i].innerHTML;
            }
        }
        if(document.getElementById("searchitem").innerHTML=="")
        {
            document.getElementById("searchitem").innerHTML="<h4>Not Found!</h4>";
        }
        document.getElementById("showing").innerHTML=document.getElementById("searchitem").innerHTML;
    }
    function productPage(pid)
    {
        window.location.replace("productpage.php?id="+pid+"&qty=1");
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
