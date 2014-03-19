<?php 
    ini_set('display_startup_errors',1);
    ini_set('display_errors',1);
    error_reporting(-1);
    //Connects to database
    include("assets/includes/connect.php"); 
?>
<!DOCTYPE html>
<html>

<?php 
    //Includes head information common among all pages
    include_once('assets/includes/head.php'); 
?>

<body>
    <?php
        //Includes header, changes nav based on current page
        $current = "home"; 
        include_once('assets/includes/header.php'); 
    

    ?>

    <main role="main" class='container'>
        <section>
            <h3 class='sixteen columns'>Sale</h3>
            <?php

                //Selects all products
                $Query = $con->prepare("SELECT * FROM `products` WHERE `sale_price` > 0");
                $Query->execute();
                $Query->bind_result($id, $product_name, $description, $price, $quantity, $picture, $sale_price);

                //Goes through query results
                while ($Query->fetch()) {
                    include("assets/includes/animal.php");
                }

                $Query->close();
            ?>
        </section>
        <section>
            <h3 class='sixteen columns'>Catalog</h3>
            <div id='itemContainer'>
                <?php

                    //Selects all products
                    $Query = $con->prepare("SELECT * FROM `products` WHERE `sale_price` = 0");
                    $Query->execute();
                    $Query->bind_result($id, $product_name, $description, $price, $quantity, $picture, $sale_price);

                    //Goes through query results
                    while ($Query->fetch()) {
                        include("assets/includes/animal.php");
                    }

                    $Query->close();
                ?>
            </div>
            <div class="sixteen columns holder"></div>
        </section>
    </main>
    
    <script>
        //Pagination
        $(function(){
            $("div.holder").jPages({
                containerID : "itemContainer",
                perPage: 5
            });
        });

        //Checks for products that have no more quantity, and disable their buttons
        $( document ).ready(function(){
            $animals      = $("article");

            $animals.each(function( index ){
                $this_item      = $( this );
                $quantity       = $this_item.find(".quantity").html();
                $button         = $this_item.find("input");

                if($quantity == 0){
                    $button.attr("disabled", "disabled");
                }
                else{
                    //alert("Above zero!");
                }
            });
        });
        
        //On button click, send ajax call with appropriate data
        $("input[type='button']").click(function(){

            $this_item      = $(this).parent().parent();
            $id             = $this_item.attr("id");
            $product_name   = $this_item.find("h4").html();
            $description    = $this_item.find("p").html();
            $price          = $this_item.find(".price").html();
            $quantity       = $this_item.find(".quantity");
            $button         = $this_item.find("input");

            
            $.ajax({
                url: "LIB_project1.php",
                type: "POST",
                data: { 
                    "Function":     "addToCart",
                    "Id":           $id,
                    "Product_name": $product_name,
                    "Description":  $description,
                    "Price":        $price,
                },
                success: function(res){
                    //Update quantity on ajax call success
                    $quantity.html($quantity.html()-1);
        
                    //If after button click the quantity is 0, disable the button
                    if($quantity.html() == 0){
                        $button.attr("disabled", "disabled");
                    }
                }
            });
        });
    </script>
</body>
</html>