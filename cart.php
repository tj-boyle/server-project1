<?php include("./assets/includes/connect.php") ?>
<!DOCTYPE html>
<html>
<?php include_once('assets/includes/head.php'); ?>
<body>
    <?php
        $current = "cart"; 
        include_once('assets/includes/header.php'); 
    ?>

    <main role="main" class='container animals'>
        <section>
            <h3 class='sixteen columns'>Cart</h3>
            <?php
                if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['UserName'])) {

                    $username       = $_SESSION['UserName'];

                    $Query = $con->prepare("SELECT UID FROM users WHERE UserName = ?");
                    $Query->bind_param('s', $username);
                    $Query->execute();
                    $res = $Query->get_result();
                    $row = $res->fetch_assoc();
                    $UID            = $row['UID'];
                    
                    $Query = "SELECT * FROM `cart` WHERE UID = $UID";
                    //Goes through query results
                    $v_TheResult = mysqli_query ($con, $Query); 
                    
                    while($row = mysqli_fetch_array($v_TheResult)){
                        include("assets/includes/animal.php");
                    }  
                }
            ?>
            <input class='sixteen columns' type='button' value='EMPTY CART'>
        </section>
    </main>

    <script>
        $( document ).ready(function(){
            if($(".cart").length == 0){
                $("input").attr("disabled", "disabled");
            }
        });

        $("input[type='button']").click(function(){
            $.ajax({
                url: "LIB_project1.php",
                type: "POST",
                data: { 
                    "Function":     "deleteCart"
                    
                },
                success: function(res){
                    $(".cart").remove();
                    $("input").attr("disabled", "disabled");
                    //document.location = "list.php?list_id=" + res;
                }
            });
        });
    </script>
</body>
</html>