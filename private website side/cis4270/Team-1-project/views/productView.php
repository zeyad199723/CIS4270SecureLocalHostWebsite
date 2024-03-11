<?php require('views/guitarShopHeader.php'); ?>
<main>
<section>
    <!-- display product -->
<?php

// Get scaled image size
$image = new Image ($vm->product->imageFilename);
$imageSize = $image->scaleWidth(150);

// Add HMTL tags to the description
$description_tags = WebText::addTags ($vm->product->description);

// Calculate and format price
$unit_price_f = number_format (round($vm->product->listPrice * (1 - $vm->product->discountPercent / 100.0), 2), 2);
?>

<h1><?php echo $vm->product->name; ?></h1>
<div id="left_column">
	<p>
	<?php if ($image->getPath() !== null) { ?>
		<img src="<?php echo $image->getPath(); ?>" 
		height="<?php echo $imageSize[1]; ?>" width="<?php echo $imageSize[0]; ?>" alt="image" />
	<?php } ?>
	</p>
</div>

<div id="right_column">
	<p>
		<b>Your Price:</b>
        <?php echo '$' . $unit_price_f; ?>
	</p>
	<form action="." method="post">
		<input type="hidden" name="ctlr" value="cart"> <input type="hidden"
			name="action" value="add"> <input type="hidden" name="product_id"
			value="<?php echo $vm->product->id; ?>"> <b>Quantity:</b>
		<input type="text" name="quantity" value="1" size="2">
		<?php echo csrf_token_tag(); ?>
		<input type="submit" value="Add to Cart">
	</form>
	<p>Shipped from <?php echo $vm->storeName; ?></p>
	<h2 class="no_bottom_margin">Description</h2>
    <?php echo $description_tags; ?>
</div>
</section>
</main>
<?php
require('views/guitarShopFooter.php');