<?php

/**
 * Controller that handles shopping cart functions of the Guitar Shop
 *  application.
 *
 * @author jam
 * @version 201106
 */
class CartController extends DefaultController {

    protected $model = null;

    public function __construct() {
        parent::__construct();
    }

    public function add() {
		$vm = ProductsVM::getCategoriesInstance();
        Page::$title = 'guitarShop - Cart';
        require(APP_NON_WEB_BASE_DIR .'views/shoppingCart.php');
    }
}
