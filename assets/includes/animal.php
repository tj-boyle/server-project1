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