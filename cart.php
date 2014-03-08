<!DOCTYPE html>
<html>
<?php include_once('assets/includes/head.php'); ?>
<body>
    <?php
        $current = "cart"; 
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
            <h3 class='sixteen columns'>Cart</h3>
            <?php
                $Query = "SELECT * FROM `cart`";
                //Goes through query results
                $v_TheResult = mysqli_query ($con, $Query); 
                
                while($row = mysqli_fetch_array($v_TheResult)){
                    include("assets/includes/animal.php");
                
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