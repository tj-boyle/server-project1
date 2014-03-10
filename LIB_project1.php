<?php
    if(isset($_POST['Function'])){
        $func = $_POST['Function'];
        
        validPOST($func);

    }

    function dbConnect(){

        include_once('credentials.php');
        $con=mysqli_connect("127.0.0.1",$username,$password)
            or die("couldn't connect: ".mysql_error());
        mysqli_select_db($con, "tjb2597");
        
        return $con;
    }

    function validPOST($func){
        if($func == "addToCart"){
            if(     isset($_POST['Id']) 
                &&  isset($_POST['Product_name']) 
                &&  isset($_POST['Description']) 
                &&  isset($_POST['Price']) 
                && (trim($_POST['Product_name']) != "New Plushie" 
                ||  trim($_POST['Product_name']) != "")
                &&  trim($_POST['Description']) != ""
                &&  is_numeric($_POST['Price'])){

                if(     $_POST['Price'] > 0
                    &&  strlen($_POST["Product_name"]) <= 20){
                    
                    addToCart();
                }
                else{
                    echo("NOT WITHIN NUM THRESHOLD");
                }
            }
            else{
                echo("NOT VALID");
                     
            }
        }
        if($func == "deleteCart"){
   
            deleteCart();
        }
        if($func == "updateItem" || $func == "addItem"){
            if(     isset($_POST['Id']) 
                &&  isset($_POST['Product_name']) 
                &&  isset($_POST['Description']) 
                &&  isset($_POST['Price']) 
                &&  isset($_POST['Quantity']) 
                &&  isset($_POST['Picture']) 
                &&  isset($_POST['Sale_price']) 
                && (trim($_POST['Product_name']) != "New Plushie" 
                ||  trim($_POST['Product_name']) != "")
                &&  trim($_POST['Description']) != ""
                && (is_numeric($_POST['Price']) 
                &&  is_numeric($_POST['Quantity']))
                &&  is_numeric($_POST['Sale_price'])){

                if(     $_POST['Price'] > 0
                    &&  $_POST['Quantity'] >= 0
                    &&  $_POST['Sale_price'] >= 0
                    &&  $_POST['Price'] < 100
                    &&  $_POST['Quantity'] < 100
                    &&  $_POST['Sale_price'] < 100
                    &&  strlen($_POST["Product_name"]) <= 20
                    &&  strlen($_POST["Picture"]) > 0){

                    if($func == "updateItem"){
                        updateItem();
                    }
                    elseif($func == "addItem"){
                        addItem();
                    }
                }
                else{
                    echo("NOT WITHIN NUM THRESHOLD");
                }
            }
            else{
     
               echo("NOT VALID");  
            }
        }
        if($func == "deleteItem"){
            if(     isset($_POST['Id']) ){   
                deleteItem();
            }
            else{
                echo("NOT SET");
            }
        }

    }

    function addTocart(){
        $con = dbConnect();
    
        $id             = $_POST['Id'];
        $product_name   = $_POST['Product_name'];
        $description    = $_POST['Description'];
        $price          = $_POST['Price'];

        //$Query = 'INSERT INTO cart(product_name, description, price) VALUES ("' . $product_name . '", "' . $description  . '" , "' . $price . '")';
        $Query = $con->prepare("INSERT INTO cart(product_name, description, price) VALUES (?,?,?)");
        $Query->bind_param('ssi', $product_name, $description, $price);
        //Goes through query results
        $Query->execute(); 

        $Query = $con->prepare("UPDATE products SET quantity = quantity - 1 WHERE id = ?");
        $Query->bind_param('i', $id);
        $Query->execute();
        
        echo($Query->fetch());
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

        //$Query = "UPDATE products SET product_name='$product_name', description='$description', price=$price, quantity=$quantity, picture='$picture', sale_price=$sale_price WHERE id=$id";

        $Query = $con->prepare("UPDATE products SET product_name = ?, description = ?, price = ?, quantity = ?, picture = ?, sale_price = ? WHERE id = ?");
        $Query->bind_param('ssiisii', $product_name, $description, $price, $quantity, $picture, $sale_price, $id);
        $Query->execute();

        echo($Query);
    }

    function deleteItem(){
        $con = dbConnect();

        $id             = $_POST['Id'];

        $Query = $con->prepare("DELETE FROM products WHERE id=?");
        $Query->bind_param('i', $id);
        $Query->execute();
        echo($id);
    }

    function addItem(){
        $con = dbConnect();

        $id             = $_POST['Id'];
        $product_name   = $_POST['Product_name'];
        $description    = $_POST['Description'];
        $price          = $_POST['Price'];
        $quantity       = $_POST['Quantity'];
        $picture        = $_POST['Picture'];
        $sale_price     = $_POST['Sale_price'];

        $Query = $con->prepare("INSERT INTO products(product_name, description, price, quantity, picture, sale_price) VALUES (?, ?, ?, ?, ?, ?)");
        $Query->bind_param('ssiisi', $product_name, $description, $price, $quantity, $picture, $sale_price);
        $Query->execute();
        echo($Query);
    }
?>