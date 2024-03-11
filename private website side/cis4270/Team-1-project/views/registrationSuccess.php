<?php require('views/guitarShopHeader.php'); ?>
<main>
<section>
    <h1>New Account Information</h1>
    <p>Here is the account information you entered:</p>
	<p>First name: <?php echo $vm->newUser->firstName; ?><br>
	   Last name: <?php echo $vm->newUser->lastName; ?><br>
	   Email address: <?php echo $vm->newUser->email; ?><br>
	   Phone number: <?php echo $vm->newUser->phoneNumber; ?></p>
    
</section>
</main>
<?php require('views/guitarShopFooter.php');