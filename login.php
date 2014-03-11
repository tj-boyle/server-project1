<?php include("assets/includes/connect.php") ?>
<!DOCTYPE html>
<html>
<?php include_once('assets/includes/head.php'); ?>
<body>
    <?php
        $current = "login";

        if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['UserName'])){
            $username       = $_SESSION['UserName'];

            $Query = $con->prepare("SELECT Type FROM users WHERE UserName = ?");
            $Query->bind_param('s', $username);
            $Query->execute();
            $res = $Query->get_result();
            $row = $res->fetch_assoc();
            $type            = $row['Type'];
        }
        
        include_once('assets/includes/header.php'); 
    ?>

    <main role="main" class='container animals'>
        <section>
            <h3 class='sixteen columns'>Login</h3>
            <?php 
                $response = "";
                $formtype = "login";
                if (!empty($_POST['username']) && !empty($_POST['password'])) { 
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

                        echo "<meta http-equiv='refresh' content='0;URL=index.php' />";
                    }
                    else {
                        $response = "not_found";
                    }
                } 

                include("assets/includes/form.php");
            ?>
        </section>
    </main>

</body>
</html>