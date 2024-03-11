<!DOCTYPE html>
<html>
    <head>
        <title><?php echo Page::$title; ?></title>
        <link rel='stylesheet' type="text/css" href='content/be-store/css/be-store.css'>  
	<link rel='stylesheet' href='content/be-store/css/be-store.css'>    
  <style>
    
    #Action_bar {
      background-color: black;
      padding: 20px;
    }
  </style>
  <title><?php echo Page::$title; ?></title>
</head> <body style="background-color: #faf2ed;"><div id="Action_bar">
					<div class="container">
						<div class="column one">
							<ul class="contact_details">
                            <li class="slogan" style="text-align: left; color: #848484; margin-left: 14em;">
                This will be your most unique website for custom graphics made shirts, sweaters, and much more!
</li>
</li>
	
</div>
					</div>
				</div>
    </head>

    <body style="background-color: #faf2ed;">
        <header>
        <div id="Top_bar">
					<div class="container">
						<div class="column one">
							<div class="top_bar_row top_bar_row-first clearfix">
								<div class="logo">
                                <div class="logo-main">
                                <img src="content/be-store/images/graffixclothing.png" style="width: 26%; background-repeat: no-repeat; background-size: cover; position: absolute; left: 0; top: 0; bottom: 40; right: 0; margin-left:14em;">
                                
                                <br>
                                <br>

    </header>
        <aside>
            <h2></h2>
            <nav>
                <ul>
                    <li>
                        <a href="?ctlr=admin&amp;action=logout">Log Out</a>
                    </li>
                    <li>
                        <a href="?ctlr=admin&amp;action=addProduct">Add Product</a>
                    </li>
                </ul>
                <h2 style="font-size: 40px; font-weight: bold; text-decoration: underline;">Listing Categories</h2>
                
                <ul>
                    <!-- display links for all categories -->
                    <?php foreach ($vm->categories as $category) { ?>
                        <li>
                            <a href="?ctlr=admin&amp;action=listProducts&amp;categoryId=<?php echo $category->id; ?>">
                                <?php echo $category->name; ?>
                            </a>
                        </li>
                    <?php } ?>
                    <li>&nbsp;</li>
                </ul>
            </nav>
        </aside>
    </body>