<header>
    <div class='container'>
        <div class='sixteen columns'>
            <h2 class='left'>Stuffed Animals</h2>
            <nav class='right'>
                <ul>
                    <li><a <?php if($current == "home") { echo("class='current'"); } ?> href='#'>HOME</a></li>
                    <li><a <?php if($current == "cart") { echo("class='current'"); } ?> href='#'>CART</a></li>
                    <li><a <?php if($current == "admin"){ echo("class='current'"); } ?> href='#'>ADMIN</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>