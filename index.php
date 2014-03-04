<!DOCTYPE html>
<html>

<?php include_once('assets/includes/head.php'); ?>

<body>
    <?php
        $current = "home"; 
        include_once('assets/includes/header.php'); 
    ?>

    <main role="main" class='container animals'>
        <?php
            include_once('credentials.php');
            $con=mysqli_connect("127.0.0.1",$username,$password)
                or die("couldn't connect: ".mysql_error());
            mysqli_select_db($con, "tjb2597");
        ?>
        <div class='section sale'>
            <h3 class='sixteen columns'>Sale</h3>
            
            <?php
                $Query = "SELECT * FROM `stuffed-animal` WHERE `sale_price` > 0";
                //Goes through query results
                $v_TheResult = mysqli_query ($con, $Query); 
                
                while($row = mysqli_fetch_array($v_TheResult)){ ?>
                <article class='eight columns animal'>
                    <div class='four columns alpha a-image' style="background-image: url('<?=$row['picture']?>');"></div>
                    <div class='four columns omega info'>
                        <h4><?=$row["product_name"]?></h4>
                        <span><?="Sale: $" . $row["sale_price"] . " - Orig: $" . $row['price'] . " - " . $row["quantity"] . " left"?></span>
                        <p><?=$row["description"]?></p>
                        <input type='button' value='ADD TO CART'>
                    </div>
                </article>
            <?php } ?>
        </div>
        <div class='section catalog'>
            <h3 class='sixteen columns'>Catalog</h3>

            <?php
                $Query = "SELECT * FROM `stuffed-animal` WHERE `sale_price` = 0";
                //Goes through query results
                $v_TheResult = mysqli_query ($con, $Query); 
                
                while($row = mysqli_fetch_array($v_TheResult)){ ?>
                <article class='eight columns animal'>
                    <div class='four columns alpha a-image'></div>
                    <div class='four columns omega info'>
                        <h4><?=$row["product_name"]?></h4>
                        <span><?="$" . $row['price'] . " - " . $row["quantity"] . " left"?></span>
                        <p><?=$row["description"]?></p>
                        <input type='button' value='ADD TO CART'>
                    </div>
                </article>
            <?php } ?>
            
        </div>
        
        
    </main>
    
    <?php

        // include_once('credentials.php');
        // $con=mysql_connect("127.0.0.1",$username,$password)
        //     or die("couldn't connect: ".mysql_error());
        // mysql_select_db("tjb2597");

        // $Query = "select * from stuffed-animal";
        // //Goes through query results
        // $v_TheResult = mysql_query ($Query); 
    ?>
</body>
</html>