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
            case "updateItem":
                updateItem();
                break;
            case "deleteItem":
                deleteItem();
                break;
        }
    }

    function dbConnect(){
        include_once('credentials.php');
        $con=mysqli_connect("127.0.0.1",$username,$password)
            or die("couldn't connect: ".mysql_error());
        mysqli_select_db($con, "tjb2597");

        return $con;
    }

    function addTocart(){
        $con = dbConnect();
    
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
        $con = dbConnect();

        $Query = "DELETE FROM `cart`";
        //Goes through query results
        $v_TheResult = mysqli_query ($con, $Query);

        echo($Query);
    }

    function updateItem(){
        $con = dbConnect();

        $id             = $_POST['Id'];
        $product_name   = $_POST['Product_name'];
        $description    = $_POST['Description'];
        $price          = $_POST['Price'];
        $quantity       = $_POST['Quantity'];
        $picture        = $_POST['Picture'];
        $sale_price     = $_POST['Sale_price'];

        $Query = "UPDATE products SET product_name='$product_name', description='$description', price=$price, quantity=$quantity, picture='$picture', sale_price=$sale_price WHERE id=$id";
        //Goes through query results
        $v_TheResult = mysqli_query ($con, $Query);
        echo($picture);

    }

    function deleteItem(){
        $con = dbConnect();

        $id             = $_POST['Id'];

        $Query = "DELETE FROM products WHERE id=$id";
        //Goes through query results
        //$v_TheResult = mysqli_query ($con, $Query);
        echo($id);
    }
?>