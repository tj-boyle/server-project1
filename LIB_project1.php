<?php
    if (isset($_POST['Function'])) {

        $func = $_POST['Function'];
        validPOST($func);
    }

    function dbConnect(){

        include_once("assets/includes/connect.php");
        return $con;
    }

    function validPOST($func){

        $validID    =   isset($_POST['Id']);
        
        $validProd  =   isset($_POST['Product_name']) 
                    &&  trim($_POST['Product_name']) != "New Plushie" 
                    &&  trim($_POST['Product_name']) != ""
                    &&  strlen($_POST["Product_name"]) <= 20;
        
        $validDesc  =   isset($_POST['Description'])
                    &&  trim($_POST['Description']) != "";

        $validPrice =   isset($_POST['Price']) 
                    &&  is_numeric($_POST['Price'])
                    &&  $_POST['Price'] > 0
                    &&  $_POST['Price'] < 100;

        $validQuant =   isset($_POST['Quantity'])
                    &&  is_numeric($_POST['Quantity'])
                    &&  $_POST['Quantity'] >= 0
                    &&  $_POST['Quantity'] < 100;

        $validSale  =   isset($_POST['Sale_price'])
                    &&  $_POST['Sale_price'] >= 0
                    &&  $_POST['Sale_price'] < 100;

        $validPic   =   isset($_POST['Picture']);

        $validALL   =   $validID 
                    &&  $validProd 
                    &&  $validDesc 
                    &&  $validPrice 
                    &&  $validQuant 
                    &&  $validSale 
                    &&  $validPic;


        if ($func == "addToCart") {      

            if ($validID && $validProd && $validDesc && $validPrice) {
                addToCart();
            }
            else{
                echo("Invalid");
            }
        }

        if ($func == "deleteCart") {
            deleteCart();
        }

        if ($func == "updateItem" || $func == "addItem") {

            if ($validALL) {

                if ($func == "updateItem") {
                    updateItem();
                }
                elseif ($func == "addItem") {
                    addItem();
                }
            }
            else{
                echo("Invalid");
            }
        }

        if ($func == "deleteItem") {
            
            if ($validID) {   
                deleteItem();
            }
            else{
                echo("Invalid");
            }
        }
    }

    function addTocart(){
        $con = dbConnect();
    
        $id             = $_POST['Id'];
        $product_name   = $_POST['Product_name'];
        $description    = $_POST['Description'];
        $price          = $_POST['Price'];
        $username       = $_SESSION['UserName'];

        $Query = $con->prepare("SELECT UID FROM users WHERE UserName = ?");
        $Query->bind_param('s', $username);
        $Query->execute();
        $res = $Query->get_result();
        $row = $res->fetch_assoc();
        $UID            = $row['UID'];
        
        //echo($UID . " ");
        //$Query = 'INSERT INTO cart(product_name, description, price) VALUES ("' . $product_name . '", "' . $description  . '" , "' . $price . '")';
        $Query = $con->prepare("INSERT INTO cart(product_name, description, price, UID) VALUES (?,?,?,?)");
        $Query->bind_param('ssii', $product_name, $description, $price, $UID);
        //Goes through query results
        $Query->execute(); 

        $Query = $con->prepare("UPDATE products SET quantity = quantity - 1 WHERE id = ?");
        $Query->bind_param('i', $id);
        $Query->execute();
        
        echo($UID);
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