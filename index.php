<!DOCTYPE html>
<html>

<?php include_once('assets/includes/head.php'); ?>

<body>
    <?php
        $current = "home"; 
        include_once('assets/includes/header.php'); 
    ?>

    <div class='container animals'>
        <div class='eight columns animal'>
            <div class='four columns alpha'>
                <div class='a-image'></div>
            </div>
            <div class='four columns omega info'>
                <h4>Bear</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed condimentum velit eu sollicitudin ornare. Integer sit amet odio quis tortor tincidunt suscipit et eu ligula.</p>
                <input type='button' value='Add To Cart'>
            </div>
        </div>
        <div class='eight columns animal'>
            <div class='a-image'></div>
        </div>
        <div class='eight columns animal'>
            <div class='a-image'></div>
        </div>
        <div class='eight columns animal'>
            <div class='a-image'></div>
        </div>
        <div class='eight columns animal'>
            <div class='a-image'></div>
        </div>
        <div class='eight columns animal'>
            <div class='a-image'></div>
        </div>
    </div>
    
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