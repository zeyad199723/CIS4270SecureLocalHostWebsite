<?php

/**
 * Controller that handles administrator functions of the guitarShop
 * application.
 *
 * @author jam
 * @version 210307
 */
class AdminController extends DefaultController {

    protected $model = null;

    public function __construct() {
        parent::__construct();
    }

    public function loginGET() {
        Page::$title = 'graffixclothing - Login';
		$vm = ProductsVM::getCategoriesInstance();
        require(APP_NON_WEB_BASE_DIR . 'views/login.php');
    }
    
    public function loginPOST() {
    	$vm = LoginVM::getInstance();
    	if ($vm->userType === LoginVM::VALID_LOGIN) {
            after_successful_login();
    		$this->listProducts(); 
    	} else {
            after_successful_logout();
    		$vm = ProductsVM::getCategoriesInstance();
    		Page::$title = 'graffixclothing - Invalid Credentials';
    		require(APP_NON_WEB_BASE_DIR .'views/loginFailed.php');
    	}
    }

    public function logout() {
        after_successful_logout();
        $vm = null;
        require(APP_NON_WEB_BASE_DIR .'views/logout.php');
       }
       
	
	public function registerGET() {
        $vm = ProductsVM::getCategoriesInstance();
        Page::$title = 'graffixclothing - Register';
        require(APP_NON_WEB_BASE_DIR . 'views/register.php');
    }
    
    public function registerPOST() {
        $vm = RegisterVM::getInstance();
        if ($vm->registrationType === RegisterVM::VALID_REGISTRATION) {
            Page::$title = 'graffixclothing - New Account';
            require(APP_NON_WEB_BASE_DIR .'views/registrationSuccess.php');
        } else {
            Page::$title = 'graffixclothing - Invalid Registration';
            require(APP_NON_WEB_BASE_DIR .'views/registrationErrors.php');
        }
    }

    public function listProducts() {
        before_every_protected_page();
        $vm = ProductsVM::getCategoryInstance();
        Page::$title = 'graffixclothing Listing - ' . $vm->category->name;
        require(APP_NON_WEB_BASE_DIR . 'views/adminProductList.php');
    }

    public function viewProduct() {
        before_every_protected_page();
        $vm = ProductsVM::getProductInstance();
        Page::$title = 'graffixclothing Listing - ' . $vm->product->name;
        require(APP_NON_WEB_BASE_DIR . 'views/adminProductView.php');
    }

    public function deleteProduct() {
        before_every_protected_page();
        $vmDelete = ProductsVM::getDeleteInstance();
        $vm = ProductsVM::getCategoryInstance($vmDelete->category->id);
        Page::$title = 'graffixclothing Listing - ' . $vm->category->name;
        require(APP_NON_WEB_BASE_DIR . 'views/adminProductList.php');
    }
    
    /**
     * Supports views that display add new product listing form
     */
    public function showAddProduct() {
        before_every_protected_page();
        $vm = ProductsVM::getCategoryInstance();
        Page::$title = 'graffixclothing - Add Product';
        require(APP_NON_WEB_BASE_DIR . 'views/addProduct.php');
    }
    
    /**
     * Adds a new product listing to the database or updates an existing listing
     */
    public function addEditProduct() {
        before_every_protected_page();
        $vmAdd = ProductsVM::getAddEditInstance();
        $vm = ProductsVM::getCategoryInstance($vmAdd->category->id);
        Page::$title = 'graffixclothing ' . $vm->category->name;
        require(APP_NON_WEB_BASE_DIR . 'views/adminProductList.php');
    }
    
    /**
     * Displays the form to edit a product listing
     */
    public function showEditProduct() {
        before_every_protected_page();
        $vm = ProductsVM::getEditProductInstance();
        Page::$title = 'graffixclothing - Edit ' . $vm->product->name;
        require(APP_NON_WEB_BASE_DIR . 'views/editProduct.php');
    }

    
}
   