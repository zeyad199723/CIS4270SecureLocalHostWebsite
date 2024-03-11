<?php require('views/guitarShopHeader.php'); ?>
<main>
<section>
    <h1>Sign-up errors</h1>
    <p>Please correct the following errors to sign up:</p>
	<p><?php echo $vm->errorMsg; ?></p>
        
</section>
</main>
<?php require('views/guitarShopFooter.php');