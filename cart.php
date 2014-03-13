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

    <main role="main" class='container animals'>
        <section>
            <h3 class='sixteen columns'>Cart</h3>
            <?php
                if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['UserName'])) {

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
                    
                    //Selects all from current users's cart
                    $Query = "SELECT * FROM `cart` WHERE UID = $UID";
                    $v_TheResult = mysqli_query ($con, $Query); 
                    
                    //Goes through query results
                    while($row = mysqli_fetch_array($v_TheResult)){
                        include("assets/includes/animal.php");
                    }  
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