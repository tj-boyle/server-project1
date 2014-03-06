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
        <section>
            <h3 class='sixteen columns'>Sale</h3>
            <?php
                $Query = "SELECT * FROM `products` WHERE `sale_price` > 0";
                //Goes through query results
                $v_TheResult = mysqli_query ($con, $Query); 
                
                while($row = mysqli_fetch_array($v_TheResult)){ 
                    
                    include("assets/includes/animal.php");

                }
            ?>
        </section>
        <section>
            <h3 class='sixteen columns'>Catalog</h3>
            <div id='itemContainer'>
                <?php
                    $Query = "SELECT * FROM `products` WHERE `sale_price` = 0";
                    //Goes through query results
                    $v_TheResult = mysqli_query ($con, $Query); 
                    
                    while($row = mysqli_fetch_array($v_TheResult)){ 

                        include("assets/includes/animal.php");

                    }
                ?>
            </div>
        </section>
        <div class="sixteen columns holder"></div>
        
    </main>
    
    <script>
        $(function(){
            $("div.holder").jPages({
                containerID : "itemContainer",
                perPage: 5
            });
        });

        $( document ).ready(function(){
            $animals      = $(".animal");

            $animals.each(function( index ){
                $this_item      = $( this );
                $quantity       = $this_item.find("#quantity").html();
                $button         = $this_item.find("input");

                if($quantity == 0){
                    $button.attr("disabled", "disabled");
                }
                else{
                    //alert("Above zero!");
                }
            });
        });
        
        $("input[type='button']").click(function(){

            $this_item      = $(this).parent().parent();
            $id             = $this_item.attr("id");
            $product_name   = $this_item.find("h4").html();
            $description    = $this_item.find("p").html();
            $price          = $this_item.find("#price").html();
            $quantity       = $this_item.find("#quantity");
            $button         = $this_item.find("input");

            
            if($quantity.html() == 0){
                $button.attr("disabled", "disabled");
            }
            else{
                $.ajax({
                    url: "LIB_project1.php",
                    type: "POST",
                    data: { 
                        "Function":     "addToCart",
                        "Id":           $id,
                        "Product_name": $product_name,
                        "Description":  $description,
                        "Price":        $price
                    },
                    success: function(res){
                        //alert(res);
                        $quantity.html($quantity.html()-1);
                        //document.location = "list.php?list_id=" + res;
                    }
                });
            }
        });
    </script>
</body>
</html>