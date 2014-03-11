<?php include("assets/includes/connect.php") ?>
<!DOCTYPE html>
<html>
<?php include_once('assets/includes/head.php'); ?>
<body>
    <?php
        $current = "register";
        include_once('assets/includes/header.php'); 
    ?>

    <main role="main" class='container animals'>
        <section>
            <h3 class='sixteen columns'>Register</h3>
            <?php
                $response = "";
                $formtype = "reg";

                if (!empty($_POST['username']) && !empty($_POST['password'])) {
                    $username = mysqli_real_escape_string($con, $_POST['username']);
                    $password = md5(mysqli_real_escape_string($con, $_POST['password']));
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    
                    $checkusername = mysqli_query($con, "SELECT * FROM users WHERE Username = '".$username."'");
                     
                    if (mysqli_num_rows($checkusername) == 1) {

                        $response = "taken";
                    }
                    else{
                        $registerquery = mysqli_query($con, "INSERT INTO users (UserName, Password, Email) VALUES('".$username."', '".$password."', '".$email."')");
                        if ($registerquery) {
                            $response = "success";
                        }
                        else{
                            $response = "failed";
                        }
                    }
                }

                include("assets/includes/form.php");
            ?>
            
            
        </section>
    </main>

</body>
</html>