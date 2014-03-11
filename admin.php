<?php include("assets/includes/connect.php") ?>
<!DOCTYPE html>
<html>
<?php include_once('assets/includes/head.php'); ?>
<body>
    <?php
        $current = "admin";
        $numSale = 0;
        include_once('assets/includes/header.php'); 
    ?>

    <main role="main" class='container animals'>

        <?php if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['UserName'])){ ?>
           <section>
                <h3 class='sixteen columns'>Admin Panel</h3>

                <?php
                    $Query = "SELECT * FROM `products`";
                    //Goes through query results
                    $v_TheResult = mysqli_query ($con, $Query); 
                    
                    $new = false;
                    while ($row = mysqli_fetch_array($v_TheResult)) { 
                        
                        if ($row["sale_price"] > 0) {
                            $numSale++;
                        }

                        include("assets/includes/animal.php");
                    }

                    $new = true;
                    include("assets/includes/animal.php");
                ?>
            </section>
        <?php } elseif (!empty($_POST['username']) && !empty($_POST['password'])) { 
            // Check user login
            $username = mysqli_real_escape_string($con, $_POST['username']);
            $password = md5(mysqli_real_escape_string($con, $_POST['password']));

            $Query = "SELECT * FROM users WHERE UserName = '" . $username  . "' AND Password = '" . $password ."'";
            $checkLogin = mysqli_query($con, $Query);

            if (mysqli_num_rows($checkLogin) == 1) {
                $row = mysqli_fetch_array($checkLogin);
                $email = $row['Email'];
               
                $_SESSION['UserName'] = $username;
                $_SESSION['Email'] = $email;
                $_SESSION['LoggedIn'] = 1;

                echo "<h1>Success</h1>";
                echo "<p>We are now redirecting you to the member area.</p>";
                echo "<meta http-equiv='refresh' content='2;URL=admin.php' />";
            }
            else {
                echo "<h1>Error</h1>";
                echo "<p>Sorry, your account could not be found."; 
            }
        ?>

        <?php } else { ?>
            <!-- Let user login -->
            <h3 class='sixteen columns'>Admin Login</h3>
            <p class='sixteen columns'>Thanks for visiting! Please either login below, or <a href="register.php">click here to register</a>.</p>
            <form class='six columns offset-by-five' method="post" action="admin.php" name="loginform" id="loginform">
            <fieldset>
                <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
                <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
                <input type="submit" name="login" id="login" value="Login" />
            </fieldset>
            </form>
        <?php } ?>
    </main>

    <script>
        numSale = 0;

        $(document).ready(function(){
            $(".admin").each(function(){
                $sale_price     = $(this).find("#price").html();
                if($sale_price > 0){
                    numSale++;
                }
            })

            console.log(numSale);
        });

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
            $pictureInput   = $this_item.find(".a-image input")
            $picture        = $pictureInput.attr("value");

            IsValidImageUrl($picture, function(result) { 

                if(result){
                    if(IsValidChange($this_item)){
                        dbChange($this_item, true);
                    }
                    else{
                        //alert("Invalid data");
                    }
                }
                else{
                    $pictureInput.css("border", "1px solid red");
                    //alert("Invalid url");
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
            $this_item           = $(item);
            $id                  = $this_item.attr("id");

            $h4                  = $this_item.find("h4");
            $product_name        = $h4.html();
            $product_name_valid  = false;

            $p                   = $this_item.find("p");
            $description         = $p.html();
            $description_valid   = false;

            $priceSpan           = $this_item.find("#orig");
            $price               = $priceSpan.html();
            $price_valid         = false;
            
            $quantitySpan        = $this_item.find("#quantity");
            $quantity            = $quantitySpan.html();
            $quantity_valid      = false;

            $sale_priceSpan      = $this_item.find("#price");
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

            if(     $sale_price == 0){
                $sale_price_valid = true;
            }

            if(     $sale_price > 0
                &&  $sale_price < 100
                &&  numSale < 5){

                numSale++;
                console.log(numSale);
                $sale_price_valid = true;
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
                    alert(res);
                    
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