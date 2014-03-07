<header>
    <div class='container'>
        <div class='sixteen columns'>
            <h2 class='left'>Plushie Planet</h2>
            <nav class='right'>
                <ul>
                    <li><a <?php if($current == "home") { echo("class='current'"); } ?> href='index.php'>HOME</a></li>
                    <li><a <?php if($current == "cart") { echo("class='current'"); } ?> href='cart.php'>CART</a></li>
                    <li><a <?php if($current == "admin"){ echo("class='current'"); } ?> href='admin.php'>ADMIN</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>