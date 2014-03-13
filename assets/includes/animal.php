<?php
    /**
    *   animal.php
    *   An include file for different pages
    *   
    *   @author Thomas Boyle <tjb2597@rit.edu>   
    *   @version 1.0
    *   
    *
    */

    /**
    *   Boolean variable for session active
    *   @var boolean
    */
    $unemptySess = !empty($_SESSION['LoggedIn']) && !empty($_SESSION['UserName']);
    
    /* 
    * If current is home or current is admin AND new is false, 
    * Output normal two column list of animals
    * Gets info from database row
    */
    if ($current == "home" || ($current == "admin" && $new == false)) : ?>
    <article class='eight columns' id="<?=$row['id']?>">
        <div class='four columns alpha a-image left' style="background-image: url('<?=$row['picture']?>');">
            <?php 
                //If current is admin with a session active, put an input over the picture
                if ($current == "admin" && $unemptySess) : ?>
                <input type='text' value="<?=$row['picture']?>">
            <?php endif; ?>
        </div>
        <div class='four columns omega info right'>
            <h4><?=$row["product_name"]?></h4>

            <?php 
            /**
            * If current is home and the sale price is 0, should output a row that
            * Doesnt have a Sale section
            */
            if ($current == "home" && $row['sale_price'] == 0): ?>
                $<span id='price'><?=$row['price']?></span> - <span id='quantity'><?=$row["quantity"]?></span> left
            
            <?php 
            /**
            * Else it will output a sale section, in the case that current is home with a sale price above
            * zero, OR if current is admin
            */
            else: ?>
                Sale: $<span id='price'><?=$row["sale_price"]?></span> - Orig: $<span id='orig'><?=$row['price']?></span> - <span id='quantity'><?=$row["quantity"]?></span> left
            
            <?php endif; ?>
            
            <p><?=$row["description"]?></p>
            
            <?php 
            /**
            * If current is home with valid session, show button to add animal to cart
            */
            if ($current == "home" && $unemptySess) : ?>
                <input type='button' value='ADD TO CART'>

            <?php 
            /**
            * Otherwise if current is admin with a valid session, show buttons for updating and deleting
            */
            elseif ($current == "admin" && $unemptySess) : ?>
                <input type='button' value='UPDATE' class='update'>
                <input type='button' value='DELETE' class='delete' >

            <?php endif; ?>
        </div>
    </article>

<?php 
    /**
    * If current is admin and the the new variable is true,
    * Output an box with default values to insert a new animal to the database
    */
    elseif ($current == "admin" && $new == true) : ?>
    <article class='eight columns list' id="-1">
        <div class='four columns alpha a-image' style="background-image: url('');"><input type='text' placeholder='Image url...'></div>
        <div class='four columns omega info'>
            <h4> New Plushie</h4>
            Sale: $<span id='price'>0</span> - Orig: $<span id='orig'>0</span> -<span id='quantity'>0</span>left
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <input type='button' value='ADD' class='add'>
        </div>
    </article>

<?php 
    /**
    * Otherwise if the current page is cart, it will only output the product name, price,
    * quantity and description in a list that is only one column filling the width of the container
    */
    elseif($current == "cart"): ?>
    <article class='sixteen columns cart' id="<?=$row['id']?>">
        <h4><?=$row["product_name"]?></h4>
        $<span id='price'><?=$row['price']?></span> - <span id='quantity'>1</span>
        <p><?=$row["description"]?></p>
    </article>

<?php endif; ?>