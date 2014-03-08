<!DOCTYPE html>
<html>
<?php include_once('assets/includes/head.php'); ?>
<body>
    <?php
        $current = "admin"; 
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
            <h3 class='sixteen columns'>Admin Panel</h3>
            <?php
                $Query = "SELECT * FROM `products`";
                //Goes through query results
                $v_TheResult = mysqli_query ($con, $Query); 
                
                while($row = mysqli_fetch_array($v_TheResult)){ 
                    
                    include("assets/includes/animal.php");

                }
            ?>

        </section>
    </main>
    <script>
        $(".update").click(function(){

            $this_item      = $(this).parent().parent();
            $id             = $this_item.attr("id");
            $product_name   = $this_item.find("h4").html();
            $description    = $this_item.find("p").html();
            $price          = $this_item.find("#orig").html();
            $quantity       = $this_item.find("#quantity").html();
            $picture        = $this_item.find(".a-image input").attr("value");
            $sale_price     = $this_item.find("#price").html();

            $.ajax({
                url: "LIB_project1.php",
                type: "POST",
                data: { 
                    "Function":     "updateItem",
                    "Id":           $id,
                    "Product_name": $product_name,
                    "Description":  $description,
                    "Price":        $price,
                    "Quantity":     $quantity,
                    "Picture":      $picture,
                    "Sale_price":   $sale_price,
                },
                success: function(res){
                    //alert(res);
                    $this_item.find(".a-image").css('background-image', 'url(' + res + ')');
                    //$quantity.html($quantity.html()-1);
                    
                },
                error: function(res){
                    alert(res);
                },
            });
        });

        $(".delete").click(function(){

            $this_item      = $(this).parent().parent();
            $id             = $this_item.attr("id");

            $.ajax({
                url: "LIB_project1.php",
                type: "POST",
                data: { 
                    "Function":     "deleteItem",
                    "Id":           $id,
                },
                success: function(res){
                    //alert(res);
                    alert(res);
                    document.getElementById(res).remove();
                    //$(res).remove();
                    //$quantity.html($quantity.html()-1);
                    //document.location = "list.php?list_id=" + res;
                }
            });
        });
    </script>
</body>
</html>