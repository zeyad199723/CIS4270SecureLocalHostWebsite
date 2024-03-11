<?php

/**
 * Controller that handles home page functions of the Guitar Shop application.
 *
 * @author jam
 * @version 210222
 */
class HomeController extends DefaultController {

    protected $model = null;

    public function __construct() {
        parent::__construct();
    }

    // Method to display the invalid form page.
public function invalidForm() {
    Page::$title = 'graffixclothing - Invalid Form';
    require(APP_NON_WEB_BASE_DIR .'views/invalidForm.php');
   }
   
    public function listProducts() {
        $vm = ProductsVM::getCategoryInstance();
        Page::$title = 'graffixclothing - ' . $vm->category->name;
        require(APP_NON_WEB_BASE_DIR .'views/categoryProductList.php');
    }
    
    public function viewProduct() {
        $vm = ProductsVM::getProductInstance();
        Page::$title = 'graffixclothing - ' . $vm->product->name;
        require(APP_NON_WEB_BASE_DIR .'views/productView.php');
    }
}
