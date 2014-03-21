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
        $current = "register";        
        include_once('assets/includes/header.php'); 
    

    ?>

    <main role="main" class='container'>
        <section>
            <h3 class='sixteen columns'>Register</h3>
            <?php
                $response = "";

                /**
                *   Boolean variable for valid post variables
                *   @var boolean
                */
                $validReg    = !empty($_POST['username']) 
                            && !empty($_POST['password'])
                            && !empty($_POST['email']);

                if ($validReg) {
                    //Check user registration
                    $username = mysqli_real_escape_string($con, $_POST['username']);
                    $password = md5(mysqli_real_escape_string($con, $_POST['password']));
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    

                    /**
                    *   Checks if username already exists in users database
                    *   @var integer
                    */
                    $Query = $con->prepare("SELECT * FROM users WHERE UserName = ?");
                    $Query->bind_param('s', $username);
                    $Query->execute();
                    $Query->store_result();
                    $numRows = $Query->num_rows;

                    /**
                    *   Logic to determine response variable based on query responses.
                    *   
                    *   This variable gets sent to the form include, which will output
                    *   appropriate messages. 
                    */
                    if ($Query->num_rows == 1) {
                        $response = "taken";
                    }
                    else{
                        // Attempts query to add user, sets variable based on success or fail
                        $registerquery = $con->prepare("INSERT INTO users (UserName, Password, Email) VALUES(?, ?, ?)");
                        $registerquery->bind_param('sss', $username, $password, $email);
                        $registerquery->execute();
                        $registerquery->store_result();

                        if (!empty($registerquery)) {
                            $response = "success";
                        }
                        else{
                            $response = "failed";
                        }
                    }
                }

                //Formtype variable for use in the form include
                $formtype = "reg";
                include("assets/includes/form.php");
            ?>            
        </section>
    </main>
    
    <script>
        /**
        *   Function to validate username, password, and email input on client side
        */
        function validate()
        {
            var usernameInput = document.getElementById("username");
            $username = usernameInput.value;

            var passwordInput = document.getElementById("password"); 
            $password = passwordInput.value;

            var emailInput = document.getElementById("email"); 
            $email = emailInput.value;
            
            $validName  = $username != "" && $username.length < 25;
            $validPass  = $password != "";
            $validEmail = $email    != "" && $email.indexOf("@") >= 0; 

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

            if (!$validEmail) {
                emailInput.style.border="1px solid red";
            }
            else{
                emailInput.style.border="1px solid grey";
            }

            if ($validPass && $validName && $validEmail) {
                return true;
            }
            
            return false;
        }
    </script>
</body>
</html>