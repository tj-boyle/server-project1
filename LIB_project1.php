<?php
    if(isset($_POST['Function'])){

        $func = $_POST['Function'];
        
        switch ($func) {
            case "addToCart":
                addToCart();
                break; 
        }
    }

    function addTocart(){
        include_once('credentials.php');
        $con=mysqli_connect("127.0.0.1",$username,$password)
            or die("couldn't connect: ".mysql_error());
        mysqli_select_db($con, "tjb2597");
    
        $product_name   = $_POST['Product_name'];
        $description    = $_POST['Description'];
        $price          = $_POST['Price'];

        $Query = 'INSERT INTO cart(product_name, description, price) VALUES ("' . $product_name . '", "' . $description  . '" , "' . $price . '")';
        //Goes through query results
        $v_TheResult = mysqli_query ($con, $Query); 

        echo($Query);
    }
?>