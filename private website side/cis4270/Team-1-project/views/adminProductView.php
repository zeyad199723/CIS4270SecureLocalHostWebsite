<?php require('views/guitarShopAdminHeader.php'); ?>
<main>
<section>
    <h2>View Product Listing</h2>
    
    <!-- display product -->
<?php

// Get scaled image size
$image = new Image ($vm->product->imageFilename);
$imageSize = $image->scaleWidth(150);
$imageSrc = "picturesuploaded/" . $vm->product->imageFilename;

// Add HMTL tags to the description
$description_tags = WebText::addTags ($vm->product->description);

// Calculate and format prices
$list_price_f = number_format($vm->product->listPrice, 2);
$unit_price_f = number_format(round($vm->product->listPrice * (1 - $vm->product->discountPercent / 100.0), 2), 2);
?>

<h1><?php echo $vm->product->name; ?></h1>
<div id="left_column">
	<p>
    <?php  ?>
		<img src="<?php echo $imageSrc ?>"  
		height="<?php echo $imageSize[1]; ?>" width="<?php echo $imageSize[0]; ?>" alt="image" />
	<?php ?>
	<?php if ($image->getPath() !== null) { ?>
		<img src="<?php echo $image->getPath(); ?>" 
		height="<?php echo $imageSize[1]; ?>" width="<?php echo $imageSize[0]; ?>" alt="image" />
	<?php } ?>
	</p>
</div>
<div>
    
</div>

<div id="right_column">
	<p>
		List price: <?php echo '$' . $list_price_f; ?><br/>
		Discount: <?php echo $vm->product->discountPercent; ?>%<br/>
		Discounted Price: <?php echo '$' . $unit_price_f; ?>
	</p>
	
<h2 class="no_bottom_margin">Description</h2>
<?php echo $description_tags; 

$csrf_token=create_csrf_token();


?>

    <!-- display buttons -->
    <form action="." method="post" id="edit_button_form">
        <input type="hidden" name="ctlr" value="admin"/>
        <input type="hidden" name="action" value="showEditProduct"/>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" >
        <input type="hidden" name="productId" value="<?php echo $vm->product->id; ?>" />
        <input type="hidden" name="categoryId" value="<?php echo $vm->product->categoryId; ?>" />
        <input type="submit" value="Edit Product" />
    </form>
    <form action="." method="post" >
        <input type="hidden" name="ctlr" value="admin"/>
        <input type="hidden" name="action" value="deleteProduct"/>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" >
        <input type="hidden" name="productId" value="<?php echo $vm->product->id; ?>" />
        <input type="hidden" name="categoryId" value="<?php echo $vm->product->categoryId; ?>" />
        <input type="submit" value="Delete Product"/>
    </form>
    </div>
</section>
</main>
<?php require('views/guitarShopFooter.php');