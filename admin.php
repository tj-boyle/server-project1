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
                
                $new = false;
                while($row = mysqli_fetch_array($v_TheResult)){ 
                    
                    include("assets/includes/animal.php");

                }

                $new = true;
                include("assets/includes/animal.php");

            ?>
            

        </section>
    </main>
    <script>

        $(".update").click(function(){
            $this_item      = $(this).parent().parent();
            $picture        = $this_item.find(".a-image input").attr("value");
            IsValidImageUrl($picture, function(result) { 

                if(result){
                    if(IsValidChange($this_item)){
                        dbChange($this_item, false);
                    }
                    else{
                        alert("Invalid data");
                    }
                }
                else{
                    $this_item.find(".a-image input").css("border", "1px solid red");
                    alert("Invalid url");
                }

            });
        });

        $(".add").click(function(){
            $this_item      = $(this).parent().parent();
            $picture        = $this_item.find(".a-image input").attr("value");
            IsValidImageUrl($picture, function(result) { 

                if(result){
                    if(IsValidChange($this_item)){
                        dbChange($this_item, true);
                    }
                    else{
                        alert("Invalid data");
                    }
                }
                else{
                    alert("Invalid url");
                }

            });
        })

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
                    document.getElementById(res).remove();
                }
            });
        });

        function IsValidImageUrl(url, callback) {
            $('<img>', {
                src: url, 
                load: function() { callback(true); }, 
                error: function() { callback(false); }
            });
        }

        function IsValidChange(item){
            $this_item      = $(item);
            $id             = $this_item.attr("id");
            $product_name   = $this_item.find("h4").html();
            $description    = $this_item.find("p").html();
            $price          = $this_item.find("#orig").html();
            $quantity       = $this_item.find("#quantity").html();
            $sale_price     = $this_item.find("#price").html();
            $picture        = $this_item.find(".a-image input").attr("value");


            if(     $product_name.length <= 20
                &&  $product_name != "New Plushie"  
                &&  $description  != ""
                &&  $price < 100
                &&  $price > 0
                &&  $quantity < 100
                &&  $quantity >= 0
                &&  $sale_price < 100
                &&  $sale_price >= 0
                &&  $picture != ""
            ){
                return true;
            }
            else{
                return false;
            }
            
            
        }

        function dbChange(item, newItem){
            $this_item      = $(item);
            $id             = $this_item.attr("id");
            $product_name   = $this_item.find("h4").html();
            $description    = $this_item.find("p").html();
            $price          = $this_item.find("#orig").html();
            $quantity       = $this_item.find("#quantity").html();
            $picture        = $this_item.find(".a-image input").attr("value");
            $sale_price     = $this_item.find("#price").html();
            

            //alert($quantity);
            if(newItem == false){
                $func = "updateItem";
            }
            else{
                $func = "addItem";
            }

            $.ajax({
                url: "LIB_project1.php",
                type: "POST",
                data: { 
                    "Function":     $func,
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
                    
                    if(newItem == false){
                        $this_item.find(".a-image").css('background-image', 'url(' + res + ')');
                    }
                    else{
                        //Temporary update fix
                        document.location.reload();
                    } 
                },
                error: function(res){
                    alert(res);
                },
            });   
        }


    </script>
</body>
</html>