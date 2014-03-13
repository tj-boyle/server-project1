<?php

    /**
    *   LIB_project1.php
    *   Contains all ajax call functions for various files
    *   
    *   @author Thomas Boyle <tjb2597@rit.edu>   
    *   @version 1.0
    *   
    *
    */

    if (isset($_POST['Function'])) {

        $func = $_POST['Function'];
        validPOST($func);
    }

    /**
    *   Connect to the database, calls in connect include file
    *   @return mysql connections
    */
    function dbConnect(){

        include_once("assets/includes/connect.php");
        return $con;
    }

    /**
    *   Validates all necessary POST variables
    *   and calls appropriate function if valid based on passed in $func variable
    *   @return mysql connections
    *   @param string $func function to call
    *   
    */
    function validPOST($func){

        /**
        *   Valid ID boolean
        *   @var boolean
        */
        $validID    =   isset($_POST['Id']);

        /**
        *   Valid Product name boolean
        *   @var boolean
        */        
        $validProd  =   isset($_POST['Product_name']) 
                    &&  trim($_POST['Product_name']) != "New Plushie" 
                    &&  trim($_POST['Product_name']) != ""
                    &&  strlen($_POST["Product_name"]) <= 20;
        
        /**
        *   Valid Description boolean
        *   @var boolean
        */
        $validDesc  =   isset($_POST['Description'])
                    &&  trim($_POST['Description']) != "";

        /**
        *   Valid Price boolean
        *   @var boolean
        */
        $validPrice =   isset($_POST['Price']) 
                    &&  is_numeric($_POST['Price'])
                    &&  $_POST['Price'] > 0
                    &&  $_POST['Price'] < 100;

        /**
        *   Valid Quantity boolean
        *   @var boolean
        */
        $validQuant =   isset($_POST['Quantity'])
                    &&  is_numeric($_POST['Quantity'])
                    &&  $_POST['Quantity'] >= 0
                    &&  $_POST['Quantity'] < 100;

        /**
        *   Valid Sale Price boolean
        *   @var boolean
        */
        $validSale  =   isset($_POST['Sale_price'])
                    &&  $_POST['Sale_price'] >= 0
                    &&  $_POST['Sale_price'] < 100;

        /**
        *   Valid Picture boolean
        *   @var boolean
        */
        $validPic   =   isset($_POST['Picture']);
        
        /**
        *   Valid ALL POST variables boolean
        *   @var boolean
        */
        $validALL   =   $validID 
                    &&  $validProd 
                    &&  $validDesc 
                    &&  $validPrice 
                    &&  $validQuant 
                    &&  $validSale 
                    &&  $validPic;

        //If addToCart, check for valid ID, product name, description, and price, then call addToCart()
        if ($func == "addToCart") {      

            if ($validID && $validProd && $validDesc && $validPrice) {
                addToCart();
            }
            else{
                echo("Invalid");
            }
        }

        //If deleteCart, call deleteCart()
        if ($func == "deleteCart") {
            deleteCart();
        }

        //If updateItem or addItem, check that all POST variables are valid, call appropriate method
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

        //If deleteItem, check valid ID
        if ($func == "deleteItem") {
            
            if ($validID) {   
                deleteItem();
            }
            else{
                echo("Invalid");
            }
        }
    }

    /**
    *   A function to add information to the cart
    */
    function addTocart(){
        /**
        *   Connect to database
        */
        $con = dbConnect();
    
        /**
        *   Save ID POST
        *   @var integer
        */
        $id             = $_POST['Id'];

        /**
        *   Save Product Name POST
        *   @var string
        */
        $product_name   = $_POST['Product_name'];

        /**
        *   Save Description POST
        *   @var string
        */
        $description    = $_POST['Description'];

        /**
        *   Save Price POST
        *   @var integer
        */
        $price          = $_POST['Price'];


        /**
        *   Save username from SESSION
        *   @var string
        */
        $username       = $_SESSION['UserName'];

        /**
        *   Retrieves the current session UID
        *   @var integer
        */
        $Query = $con->prepare("SELECT UID FROM users WHERE UserName = ?");
        $Query->bind_param('s', $username);
        $Query->execute();
        $res = $Query->get_result();
        $row = $res->fetch_assoc();
        $UID            = $row['UID'];
        
        //Inserts into current users's cart        
        $Query = $con->prepare("INSERT INTO cart(product_name, description, price, UID) VALUES (?,?,?,?)");
        $Query->bind_param('ssii', $product_name, $description, $price, $UID);
        $Query->execute(); 

        //Lowers appropriate product quantity by 1
        $Query = $con->prepare("UPDATE products SET quantity = quantity - 1 WHERE id = ?");
        $Query->bind_param('i', $id);
        $Query->execute();
        
        echo($UID);
    }

    /**
    * Function to remove all items from cart from current user
    */
    function deleteCart(){
        /**
        *   Connect to database
        */
        $con = dbConnect();

        /**
        *   Save username from SESSION
        *   @var string
        */
        $username       = $_SESSION['UserName'];

        /**
        *   Retrieves the current session UID
        *   @var integer
        */
        $Query = $con->prepare("SELECT UID FROM users WHERE UserName = ?");
        $Query->bind_param('s', $username);
        $Query->execute();
        $res = $Query->get_result();
        $row = $res->fetch_assoc();
        $UID            = $row['UID'];

        //Deletes appropriate items from cart for current user
        $Query = $con->prepare("DELETE FROM `cart` WHERE UID = ?");
        $Query->bind_param('i', $UID);
        $Query->execute(); 

        //Goes through query results
        $v_TheResult = mysqli_query ($con, $Query);
        echo($Query);
    }

    /**  
    * Function to update item values 
    */
    function updateItem(){
        /**
        *   Connect to database
        */
        $con = dbConnect();

        /**
        *   Save ID POST
        *   @var integer
        */
        $id             = $_POST['Id'];

        /**
        *   Save Product Name POST
        *   @var string
        */
        $product_name   = $_POST['Product_name'];

        /**
        *   Save Description POST
        *   @var string
        */
        $description    = $_POST['Description'];

        /**
        *   Save Price POST
        *   @var integer
        */
        $price          = $_POST['Price'];

        /**
        *   Save Quantity POST
        *   @var integer
        */
        $quantity       = $_POST['Quantity'];

        /**
        *   Save Picture POST
        *   @var string
        */
        $picture        = $_POST['Picture'];

        /**
        *   Save Sale Price POST
        *   @var integer
        */
        $sale_price     = $_POST['Sale_price'];

        //Updates products with all updated POST variables
        $Query = $con->prepare("UPDATE products SET product_name = ?, description = ?, price = ?, quantity = ?, picture = ?, sale_price = ? WHERE id = ?");
        $Query->bind_param('ssiisii', $product_name, $description, $price, $quantity, $picture, $sale_price, $id);
        $Query->execute();

        echo($Query);
    }

    /*
    *   Deletes item based on the ID sent
    */
    function deleteItem(){
        /**
        *   Connect to database
        */
        $con = dbConnect();

        /**
        *   Save ID POST
        *   @var integer
        */
        $id             = $_POST['Id'];

        //Deletes from products where id matches id variable
        $Query = $con->prepare("DELETE FROM products WHERE id=?");
        $Query->bind_param('i', $id);
        $Query->execute();
        echo($id);
    }

    /*
    *   Adds new item to the products table
    */
    function addItem(){
        /**
        *   Connect to database
        */
        $con = dbConnect();

        /**
        *   Save ID POST
        *   @var integer
        */
        $id             = $_POST['Id'];

        /**
        *   Save Product Name POST
        *   @var string
        */
        $product_name   = $_POST['Product_name'];

        /**
        *   Save Description POST
        *   @var string
        */
        $description    = $_POST['Description'];

        /**
        *   Save Price POST
        *   @var integer
        */
        $price          = $_POST['Price'];

        /**
        *   Save Quantity POST
        *   @var integer
        */
        $quantity       = $_POST['Quantity'];

        /**
        *   Save Picture POST
        *   @var string
        */
        $picture        = $_POST['Picture'];

        /**
        *   Save Sale Price POST
        *   @var integer
        */
        $sale_price     = $_POST['Sale_price'];

        //Inserts into the products table the appropriate variables
        $Query = $con->prepare("INSERT INTO products(product_name, description, price, quantity, picture, sale_price) VALUES (?, ?, ?, ?, ?, ?)");
        $Query->bind_param('ssiisi', $product_name, $description, $price, $quantity, $picture, $sale_price);
        $Query->execute();
        echo($Query);
    }
?>