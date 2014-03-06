<?php
    if(isset($_POST['Function'])){

        $func = $_POST['Function'];
        
        switch ($func) {
            case "addToCart":
                addToCart();
                break; 
            case "deleteCart":
                deleteCart();
                break;
        }
    }

    function addTocart(){
        include_once('credentials.php');
        $con=mysqli_connect("127.0.0.1",$username,$password)
            or die("couldn't connect: ".mysql_error());
        mysqli_select_db($con, "tjb2597");
    
        $id             = $_POST['Id'];
        $product_name   = $_POST['Product_name'];
        $description    = $_POST['Description'];
        $price          = $_POST['Price'];

        $Query = 'INSERT INTO cart(product_name, description, price) VALUES ("' . $product_name . '", "' . $description  . '" , "' . $price . '")';
        //Goes through query results
        $v_TheResult = mysqli_query ($con, $Query); 

        $Query = "UPDATE products SET quantity = quantity - 1 WHERE id = $id";
        $v_TheResult = mysqli_query ($con, $Query); 
        echo($Query);
    }

    function deleteCart(){
        include_once('credentials.php');
        $con=mysqli_connect("127.0.0.1",$username,$password)
            or die("couldn't connect: ".mysql_error());
        mysqli_select_db($con, "tjb2597");

        $Query = "DELETE FROM `cart`";
        //Goes through query results
        $v_TheResult = mysqli_query ($con, $Query);

        echo($Query);
    }
?>