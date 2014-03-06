<!DOCTYPE html>
<html>

<?php include_once('assets/includes/head.php'); ?>
<body>
    <?php
        $current = "cart"; 
        include_once('assets/includes/header.php'); 
    ?>

    <main role="main" class='container animals'>
        <?php
            include_once('credentials.php');
            $con=mysqli_connect("127.0.0.1",$username,$password)
                or die("couldn't connect: ".mysql_error());
            mysqli_select_db($con, "tjb2597");
        ?>
        <section>
            <h3 class='sixteen columns'>Cart</h3>
            <?php
                $Query = "SELECT * FROM `cart`";
                //Goes through query results
                $v_TheResult = mysqli_query ($con, $Query); 
                
                while($row = mysqli_fetch_array($v_TheResult)){ ?> 
                    <article class='sixteen columns animal cart' id="<?=$row['id']?>">
                        <h4><?=$row["product_name"]?></h4>
                        $<span id='price'><?=$row['price']?></span> - <span id='quantity'>1</span>
                        <p><?=$row["description"]?></p>
                    </article>
            <?php } ?>
            
        </section>

        <input class='sixteen columns' type='button' value='EMPTY CART'>
    </main>


</body>
</html>