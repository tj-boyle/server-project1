<?php if($current == "home"): ?>
    
    <article class='eight columns animal list' id="<?=$row['id']?>">
        <div class='four columns alpha a-image' style="background-image: url('<?=$row['picture']?>');"></div>
        <div class='four columns omega info'>
            <h4><?=$row["product_name"]?></h4>
            <?php if ($row['sale_price'] == 0): ?>
                $<span id='price'><?=$row['price']?></span> - <span id='quantity'><?=$row["quantity"]?></span> left
            <?php else: ?>
                Sale: $<span id='price'><?=$row["sale_price"]?></span> - Orig: $<span id='orig'><?=$row['price']?></span> - <span id='quantity'><?=$row["quantity"]?></span> left
            <?php endif; ?>
            <p><?=$row["description"]?></p>
            <input type='button' value='ADD TO CART'>
        </div>
    </article>

<?php elseif($current == "cart"): ?>

    <article class='sixteen columns animal cart' id="<?=$row['id']?>">
        <h4><?=$row["product_name"]?></h4>
        $<span id='price'><?=$row['price']?></span> - <span id='quantity'>1</span>
        <p><?=$row["description"]?></p>
    </article>

<?php elseif($current = "admin"): ?>

    <article class='eight columns animal list admin' id="<?=$row['id']?>">
        <div contenteditable='true' class='four columns alpha a-image' style="background-image: url('<?=$row['picture']?>');"><input type='text' value="<?=$row['picture']?>"></div>
        <div class='four columns omega info'>
            <h4 contenteditable='true'><?=$row["product_name"]?></h4>
            Sale: $<span contenteditable='true' id='price'><?=$row["sale_price"]?></span> - Orig: $<span contenteditable='true' id='orig'><?=$row['price']?></span> - <span contenteditable='true' id='quantity'><?=$row["quantity"]?></span> left
            <p contenteditable='true'><?=$row["description"]?></p>
            <input type='button' value='UPDATE' class='update'>
            <input type='button' value='DELETE' class='delete' >
        </div>
    </article>

<?php endif; ?>