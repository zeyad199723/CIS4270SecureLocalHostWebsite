
<?php require('views/guitarShopHeader.php'); ?>

<main>
  <section>
  <h1 style="font-size: 40px; font-weight: bold; text-decoration: underline;">graffixclothing Login :</h1>
    <form action="?ctlr=admin&action=login" method="post">
      <input type="hidden" name="ctlr" value="admin">
      <input type="hidden" name="action" value="login">
      <?php echo csrf_token_tag(); ?>
      <label>Email:</label>
      <input type="text" name="username" value="ze@me.com" size="25">
      <label>&nbsp;Password:</label>
      <input type="password" value="123456789" name="password" size="25">
      <br><br>
      <input type="submit" name="submit" value="Login">
    </form>

    <p>Don't have an account yet?
      <a href="?ctlr=admin&amp;action=register">Sign up now</a>
    </p>
  </section>
</main>

<?php
require('views/guitarShopFooter.php');