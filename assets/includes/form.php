<div class='six columns offset-by-five form' >
    <?php
        /**
        * Wraps form in proper tag based on form type
        */ 
        if ($formtype == "reg") {
            echo "<form method='post' action='register.php' name='registerform' id='registerform'>";
        }
        elseif ($formtype =="login"){
            echo "<form method='post' action='login.php' name='loginform' id='loginform'>";
        }

        /*
        *   Outputs different mesasges based on response variable
        */
        switch ($response) {

            case "taken":
                echo "<h4>Error</h4>";
                echo "<p>Sorry, that username is taken. Please try again</p>";
                break;

            case "success":
                echo "<h4>Success</h4>";
                echo "<p>Your account was successfully created. Please<a href=\"login.php\">click here to login</a>.</p>";
                break;

            case "failed":
                echo "<h4>Error</h4>";
                echo "<p>Sorry, your registration failed. Please try again.</p>";
                break;

            case "not_found":
                echo "<h4>Error</h4>";
                echo "<p>Sorry, your your account could not be found. Please try again.</p>";
                break;
        }
    ?>
    <fieldset>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" /><br />
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" /><br />
        
        <?php 
            // Displays email address field and register button for registration type form
            if ($formtype == "reg"): ?>
            <label for="email">Email Address:</label>
            <input type="text" name="email" id="email" /><br />
            <input type="submit" name="register" id="register" value="Register" />
        
        <?php 
            //Displays the login button and NOT email field if it is a login type form
            elseif ($formtype == "login"): ?>
            <input type="submit" name="login" id="login" value="Login" />
        
        <?php endif ?>
    </fieldset>
</div>