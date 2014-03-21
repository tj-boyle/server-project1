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
        $current = "cart"; 
        include_once('assets/includes/header.php'); 
    

    ?>

    <main role="main" class='container'>
        <section>
            <h3 class='sixteen columns'>Cart</h3>
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
                    
                    /**
                    *   Save UID from SESSION
                    *   @var integer
                    */
                    $UID = $_SESSION['UID'];


                    //Selects all from current users's cart
                    $Query = $con->prepare("SELECT id, product_name, description, price, quantity FROM `cart` WHERE UID = ?");
                    $Query->bind_param('i', $UID);
                    $Query->execute();
                    $Query->bind_result($id, $product_name, $description, $price, $quantity);
                    //$v_TheResult = mysqli_query ($con, $Query); 
                    
                    //var_dump($Query);
                    //Goes through query results
                    while ($Query->fetch()) {
                        include("assets/includes/animal.php");
                    }

                    $Query->close();
                }
            ?>
            <input class='sixteen columns' type='button' value='EMPTY CART'>
        </section>
    </main>

    <script>
        //Checks for empty cart, disables button if empty
        $( document ).ready(function(){
            if($(".cart").length == 0){
                $("input").attr("disabled", "disabled");
            }
        });

        //On button click, send ajax call with appropriate data
        $("input[type='button']").click(function(){
            $.ajax({
                url: "LIB_project1.php",
                type: "POST",
                data: { 
                    "Function":     "deleteCart"
                    
                },
                success: function(res){
                    //If successful, remove all items from cart in HTML, and disable button
                    $(".cart").remove();
                    $("input").attr("disabled", "disabled");
                    //document.location = "list.php?list_id=" + res;
                }
            });
        });
    </script>
</body>
</html>