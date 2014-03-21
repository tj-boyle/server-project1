<?php 
    //Connects to database
    include("assets/includes/connect.php"); ?>
<!DOCTYPE html>
<html>

<?php 
    //Includes head information common among all pages
    include_once('assets/includes/head.php'); ?>

<body>
    <?php
        //Includes header, changes nav based on current page
        $current = "admin";
        include_once('assets/includes/header.php'); 
        
        $numSale = 0;
    ?>

    <main role="main" class='container'>
        <section>
            <h3 class='sixteen columns'>Admin Panel</h3>
            <?php 
                /**
                *   Boolean variable for session active
                *   @var boolean
                */
                $unemptySess = !empty($_SESSION['LoggedIn']) && !empty($_SESSION['UserName']);

                if ($unemptySess) { 
                    /**
                    *   Save username from SESSION
                    *   @var string
                    */
                    $username       = $_SESSION['UserName'];

                    // If account type is 1, it is an administrator account
                    if ($type == 1) {

                         //Selects all products
                        $Query = $con->prepare("SELECT * FROM `products`");
                        $Query->execute();
                        $Query->bind_result($id, $product_name, $description, $price, $quantity, $picture, $sale_price);
                       
                        //Goes through query results, includes animal with editable content
                        $new = false;
                        while ($Query->fetch()) { 
                            
                            //Increments numSale variable
                            if ($sale_price > 0) {
                                $numSale++;
                            }

                            include("assets/includes/animal.php");
                        }

                        //Creates animal with black spots for new animals
                        $new = true;
                        include("assets/includes/animal.php");
                    }
                    else { 
                        //Not authorized message if at page without authorization
                        echo("<div class='six columns offset-by-five form'>");
                        echo("<h4 >Error: Not authorized</h4>");
                        echo("</div>");
                    }
                }

                else{
                    //Not authorized message if at page without authorization
                    echo("<div class='six columns offset-by-five form'>");
                    echo("<h4 >Error: Not authorized</h4>");
                    echo("</div>");
                }
            ?>
        </section>
    </main>

    <script>
        numSale = 0;

        //Checks ammount of items on sale when document loads
        //Also sets appropriate elements to editable
        $(document).ready(function(){

            $("article").each(function(){
                $(this).find(".a-image input").attr("contenteditable","true");
                $(this).find("h4").attr("contenteditable","true");
                $(this).find(".price").attr("contenteditable","true");
                $(this).find(".orig").attr("contenteditable","true");
                $(this).find(".quantity").attr("contenteditable","true");
                $(this).find("p").attr("contenteditable","true");
            });

            getSaleNum();
        });

        //Gets the sale number for valid sale price checking
        function getSaleNum(){
            
            numSale = 0;
            
            //Goes through each article and adds to numSale if price is above 0
            $("article").each(function(){
                $sale_price     = $(this).find(".price").html();
                if($sale_price > 0){
                    numSale++;
                }
                console.log($(this).find(".price").html());
            });

            console.log("numSale = " + numSale);
        }

        //On update button click, check data
        $(".update").click(function(){
            Validate(this, false);
        });

        //On add button click, check data
        $(".add").click(function(){
            Validate(this, true);
        })

        //Validates clicked item for both valid image url and valid change
        //Then it calls the dbChange function
        function Validate(item, type){
            $this_item      = $(item).parent().parent();
            $pictureInput   = $this_item.find(".a-image input")
            $picture        = $pictureInput.attr("value");

            //Checks for valid image url
            IsValidImageUrl($picture, function(result) { 
                //If valid, check rest of items are valid and call dbChange
                if(result){
                    if(IsValidChange($this_item)){
                        dbChange($this_item, type);
                    }
                    else{
                    }
                }
                else{
                    //Alert user that picture URL is invalid
                    $pictureInput.css("border", "1px solid red");
                    alert("Invalid url");
                }
            });
        }

        //On add button click, send ajax call with appropriate data
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
                    //Removes item
                    document.getElementById(res).remove();
                }
            });
        });

        //Checks src, if error then it is not a valid image url
        //If success, it is valid
        function IsValidImageUrl(url, callback) {
            $('<img>', {
                src: url, 
                load: function() { callback(true); }, 
                error: function() { callback(false); }
            });
        }

        /**
        *   Validates all necessary POST variables on the client side
        *   and returns boolean value of whether or not they are valid
        */
        function IsValidChange(item){

            getSaleNum();


            $this_item           = $(item);
            $id                  = $this_item.attr("id");

            $h4                  = $this_item.find("h4");
            $product_name        = $h4.html();
            $product_name_valid  = false;

            $p                   = $this_item.find("p");
            $description         = $p.html();
            $description_valid   = false;

            $priceSpan           = $this_item.find(".orig");
            $price               = $priceSpan.html();
            $price_valid         = false;
            
            $quantitySpan        = $this_item.find(".quantity");
            $quantity            = $quantitySpan.html();
            $quantity_valid      = false;

            $sale_priceSpan      = $this_item.find(".price");
            $sale_price          = $sale_priceSpan.html();
            $sale_price_valid    = false;

            if(     $product_name.length <= 20
                &&  $product_name != "New Plushie"
                &&  $product_name != ""){

                $product_name_valid = true;
            }

            if(     $description  != "" ){

                $description_valid = true;
            }

            if(     $price < 100
                &&  $price >  0 ){

                $price_valid = true;
            }


            if(     $quantity < 100
                &&  $quantity >= 0 ){

                $quantity_valid = true;
            }

            if(     $sale_price >= 0
                &&  $sale_price < 100
                &&  numSale <= 5
                &&  numSale >= 3
                
                ){

                $sale_price_valid = true;
            }

            if($sale_price_valid){
                console.log("Price valid");
            }

            var htmlElements = [];
            htmlElements.push($h4);
            htmlElements.push($p);
            htmlElements.push($priceSpan);
            htmlElements.push($quantitySpan);
            htmlElements.push($sale_priceSpan);

            var validity = [];
            validity.push($product_name_valid);
            validity.push($description_valid);
            validity.push($price_valid);
            validity.push($quantity_valid);
            validity.push($sale_price_valid);

            for(var index in validity){
                if(validity[index] == false){
                    htmlElements[index].css("border", "1px solid red");
                }
                else{
                    htmlElements[index].css("border", "1px solid #D4D4D4");
                }
            }

            for(var index in validity){
                if(validity[index] == false){
                    return false;
                }
            }
            
            return true;           
        }

        /*
        *   On call, get all appropriate elements and send ajax call to either update the item or
        *   add a new item, done on the server side
        */
        function dbChange(item, newItem){
            $this_item      = $(item);
            $id             = $this_item.attr("id");
            $product_name   = $this_item.find("h4").html();
            $description    = $this_item.find("p").html();
            $price          = $this_item.find(".orig").html();
            $quantity       = $this_item.find(".quantity").html();
            $picture        = $this_item.find(".a-image input").attr("value");
            console.log($picture);
            $sale_price     = $this_item.find(".price").html();

            console.log("This sale price is: " + $sale_price);

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
                    
                    // If update, updates the image url since all others are already updated 
                    // because the user input the values.                    
                    if(newItem == false){
                        $this_item.find(".a-image").css('background-image', 'url(' + res + ')');
                    }
                    // Temporary update fix for if new item. Doesnt add entire element, 
                    // just reloads page to show change
                    else{
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