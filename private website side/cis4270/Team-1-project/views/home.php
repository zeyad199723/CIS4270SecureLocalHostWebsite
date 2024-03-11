<?php require('views/guitarShopHeader.php');?>
<main>
    <section>
        <p><b>guitarShop</b> is a great marketplace for selling new and used
            musical instruments!
        </p>
        <h1>Featured products</h1>
        
        
        <table>
            <?php
            foreach ($vm->products as $product) {
            	
            	// Get scaled image size
            	$image = new Image($product->imageFilename);
            	$imageSize = $image->scaleDimensions(150);
                

                // Calculate unit price
                $unitPrice = round($product->listPrice * (1 - $product->discountPercent / 100.0), 2);

                // Get first paragraph of description
                //$descriptionWithTags = WebText::addTags($product->description);
                //$i = strpos($descriptionWithTags, "</p>");
                //$descriptionParagraph = substr($descriptionWithTags, 3, $i - 3);
                $descriptionParagraph = WebText::getFirstParagraph($product->description);
                ?>
                <tr>
                    <td class="product_image_cell">
                    <?php if ($image->getPath() !== null) { ?>
                        <img src="<?php echo $image->getPath(); ?>"
                         height="<?php echo $imageSize[1]; ?>" width="<?php echo $imageSize[0]; ?>"
                             alt="image">
                    <?php } ?>
                    </td>
                    <td class="product_info_cell">
                        <p>
                            <a href="?ctlr=home&amp;action=viewProduct&amp;productId=<?php echo $product->id; ?>">
                                   <?php echo $product->name; ?>
                            </a>
                        </p>
                        <p>
                            <b>Your price:</b>
                            $<?php echo number_format($unitPrice, 2); ?>
                        </p>
                        <p>
                            <?php echo $descriptionParagraph; ?>
                        </p>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </section>
</main>
<?php require('views/guitarShopFooter.php');
