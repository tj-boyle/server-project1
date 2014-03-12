<?php $unemptySess = !empty($_SESSION['LoggedIn']) && !empty($_SESSION['UserName']); ?>
<header>
    <div class='container'>
        <div class='sixteen columns'>
            <h2 class='left'>Plushie Planet</h2>
            <nav class='right'>
                <ul>
                    <li><a <?php if($current == "home") { echo("class='current'"); } ?> href='index.php'>HOME</a></li>
                    <li><a <?php if($current == "cart") { echo("class='current'"); } ?> href='cart.php'>CART</a></li>
                    
                    <?php if ($unemptySess && $type == 1) { ?>
                    
                        <li><a <?php if($current == "admin"){ echo("class='current'"); } ?> href='admin.php'>ADMIN</a></li>
                        <li><a href='signout.php' style="color: #4CD59C;">SIGN OUT</a></li>

                    <?php } elseif ($unemptySess) { ?>
                        
                        <li><a href='signout.php' style="color: #4CD59C;">SIGN OUT</a></li>
                    
                    <?php } else { ?>
                        
                        <li><a <?php if($current == "login"){ echo("class='current'"); } ?> href='login.php' style="color: #4CD59C;">LOGIN</a></li>
                        <li><a <?php if($current == "register"){ echo("class='current'"); } ?> href='register.php' style="color: #4CD59C;">SIGN UP</a></li>
                    
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</header>