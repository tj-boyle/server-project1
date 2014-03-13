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
        $current = "login";
        include_once('assets/includes/header.php'); 
    

    ?>

    <main role="main" class='container'>
        <section>
            <h3 class='sixteen columns'>Login</h3>
            <?php 
                $response = "";

                /**
                *   Boolean variable for valid post variables
                *   @var boolean
                */
                $validReg    = !empty($_POST['username']) 
                            && !empty($_POST['password']);


                if ($validReg) { 
                    // Check user login
                    $username = mysqli_real_escape_string($con, $_POST['username']);
                    $password = md5(mysqli_real_escape_string($con, $_POST['password']));

                    /**
                    *   Checks if username already exists in users database
                    *   @var integer
                    */
                    $Query = $con->prepare("SELECT * FROM users WHERE UserName = ? AND Password = ?");
                    $Query->bind_param('ss', $username, $password);
                    $Query->execute();
                    $res = $Query->get_result();
                    $row = $res->fetch_assoc();
                    $Query->store_result();
                    $numRows = $Query->num_rows;

                    /**
                    *   If the login is correct, sets session variables
                    *   Otherwise sets the response variable to not found in order for 
                    *   appropriate error message to be shown
                    */
                    if ($row) {

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

                //Formtype variable for use in the form include
                $formtype = "login";
                include("assets/includes/form.php");
            ?>
        </section>
    </main>

    <script>
        /**
        *   Function to validate username and password input on client side
        */
        function validate()
        {
            var usernameInput = document.getElementById("username");
            $username = usernameInput.value;

            var passwordInput = document.getElementById("password"); 
            $password = passwordInput.value;
            
            $validName = $username != "" && $username.length < 25;
            $validPass = $password != "";

            if (!$validName) {
                usernameInput.style.border="1px solid red";     
            }
            else{
                usernameInput.style.border="1px solid grey";
            }

            if (!$validPass) {
                passwordInput.style.border="1px solid red";
            }
            else{
                passwordInput.style.border="1px solid grey";
            }

            if ($validPass && $validName) {
                return true;
            }
            
            return false;
        }
    </script>
</body>
</html>