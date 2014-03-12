<?php
    $type = "";

    switch ($current) {
        case "home":
            $type = "list";
            break;

        case "cart":
            $type = "cart";
            break;

        case "admin":
            $type = "list admin";
            break;
    }

    $unemptySess = !empty($_SESSION['LoggedIn']) && !empty($_SESSION['UserName']);
?>

<?php if ($current == "home" || ($current == "admin" && $new == false)) : ?>
    <article class='eight columns' id="<?=$row['id']?>">
        <div class='four columns alpha a-image left' style="background-image: url('<?=$row['picture']?>');">
            <?php if ($current == "admin" && $unemptySess) : ?>
                <input type='text' value="<?=$row['picture']?>">
            <?php endif; ?>
        </div>
        <div class='four columns omega info right'>
            <h4><?=$row["product_name"]?></h4>

            <?php if ($current == "home" && $row['sale_price'] == 0): ?>
                $<span id='price'><?=$row['price']?></span> - <span id='quantity'><?=$row["quantity"]?></span> left
            
            <?php else: ?>
                Sale: $<span id='price'><?=$row["sale_price"]?></span> - Orig: $<span id='orig'><?=$row['price']?></span> - <span id='quantity'><?=$row["quantity"]?></span> left
            
            <?php endif; ?>
            
            <p><?=$row["description"]?></p>
            
            <?php if ($current == "home" && $unemptySess) : ?>
                <input type='button' value='ADD TO CART'>

            <?php elseif ($current == "admin" && $unemptySess) : ?>
                <input type='button' value='UPDATE' class='update'>
                <input type='button' value='DELETE' class='delete' >

            <?php endif; ?>
        </div>
    </article>

<?php elseif ($current == "admin" && $new == true) : ?>
    <article class='eight columns list' id="-1">
        <div class='four columns alpha a-image' style="background-image: url('');"><input type='text' placeholder='Image url...'></div>
        <div class='four columns omega info'>
            <h4> New Plushie</h4>
            Sale: $<span id='price'>0</span> - Orig: $<span id='orig'>0</span> -<span id='quantity'>0</span>left
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <input type='button' value='ADD' class='add'>
        </div>
    </article>

<?php elseif($current == "cart"): ?>
    <article class='sixteen columns cart' id="<?=$row['id']?>">
        <h4><?=$row["product_name"]?></h4>
        $<span id='price'><?=$row['price']?></span> - <span id='quantity'>1</span>
        <p><?=$row["description"]?></p>
    </article>

<?php endif; ?>

<!-- <?php if($current == "home"): ?>
    
    <article class='eight columns list' id="<?=$row['id']?>">
        <div class='four columns alpha a-image left' style="background-image: url('<?=$row['picture']?>');"></div>
        <div class='four columns omega info right'>
            <h4><?=$row["product_name"]?></h4>
            <?php if ($row['sale_price'] == 0): ?>
                $<span id='price'><?=$row['price']?></span> - <span id='quantity'><?=$row["quantity"]?></span> left
            <?php else: ?>
                Sale: $<span id='price'><?=$row["sale_price"]?></span> - Orig: $<span id='orig'><?=$row['price']?></span> - <span id='quantity'><?=$row["quantity"]?></span> left
            <?php endif; ?>
            <p><?=$row["description"]?></p>
            <?php if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['UserName'])) { ?>
                <input type='button' value='ADD TO CART'>

            <?php } ?>
        </div>
    </article>

<?php elseif($current == "cart"): ?>

    <article class='sixteen columns cart' id="<?=$row['id']?>">
        <h4><?=$row["product_name"]?></h4>
        $<span id='price'><?=$row['price']?></span> - <span id='quantity'>1</span>
        <p><?=$row["description"]?></p>
    </article>

<?php elseif($current = "admin"): ?>

    <?php if($new == false):?>

        <article class='eight columns list' id="<?=$row['id']?>">
            <div class='four columns alpha a-image' style="background-image: url('<?=$row['picture']?>');"><input type='text' value="<?=$row['picture']?>"></div>
            <div class='four columns omega info'>
                <h4 contenteditable='true'><?=$row["product_name"]?></h4>
                <div class='nums' tabindex="-1">
                    Sale: $<span contenteditable='true' id='price'><?=$row["sale_price"]?></span> - Orig: $<span contenteditable='true' id='orig'><?=$row['price']?></span> - <span contenteditable='true' id='quantity'><?=$row["quantity"]?></span> left
                </div>
                <p contenteditable='true'><?=$row["description"]?></p>
                <input type='button' value='UPDATE' class='update'>
                <input type='button' value='DELETE' class='delete' >
            </div>
        </article>

    <?php else: ?>

        <article class='eight columns list' id="-1">
            <div contenteditable='true' class='four columns alpha a-image' style="background-image: url('');"><input type='text' placeholder='Image url...'></div>
            <div class='four columns omega info'>
                <h4 contenteditable='true'>New Plushie</h4>
                Sale: $<span contenteditable='true' id='price'>0</span> - Orig: $<span contenteditable='true' id='orig'>0</span> -<span contenteditable='true' id='quantity'>0</span>left
                <p contenteditable='true'>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <input type='button' value='ADD' class='add'>
            </div>
        </article>

    <?php endif; ?>

<?php endif; ?> -->