<div class='six columns offset-by-five form' >
    <?php 
        if ($formtype == "reg") {
            echo "<form method='post' action='register.php' name='registerform' id='registerform'>";
        }
        elseif ($formtype =="login"){
            echo "<form method='post' action='login.php' name='loginform' id='loginform'>";
        }

        switch ($response) {

            case "taken":
                echo "<h4>Error</h4>";
                echo "<p>Sorry, that username is taken. Please try again</p>";
                break;

            case "success":
                echo "<h4>Success</h4>";
                echo "<p>Your account was successfully created. Please <a href=\"login.php\">click here to login</a>.</p>";
            
            case "fail":
                echo "<h4>Error</h4>";
                echo "<p>Sorry, your registration failed. Please try again.</p>";
                break;

            case "not_found":
                echo "<h4>Error</h4>";
                echo "<p>Sorry, your your account could not be found. Please try again.</p>";
                break;

        }
    ?>
    <?php if ($formtype == "reg") { ?>
        <fieldset>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" /><br />
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" /><br />
            <label for="email">Email Address:</label>
            <input type="text" name="email" id="email" /><br />
            <input type="submit" name="register" id="register" value="Register" />
        </fieldset>
    <?php } elseif ($formtype == "login") { ?>
        <fieldset>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" /><br />
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" /><br />
            <input type="submit" name="login" id="login" value="Login" />
        </fieldset>
    <?php } ?>
</div>