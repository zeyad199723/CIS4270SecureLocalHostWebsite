<?php

/**
 * View model for the featured products.
 *
 * @author jam
 * @version 2110307
 */
class ProductsVM {

    public $featuredProductIds;
    public $errorMsg;
    public $products;
    public $storeName;
    public $product;
    public $category;
	public $categories;
    private $productDAM;
    private $categoryDAM;

    public function __construct() {
        $this->productDAM = new ProductDAM();
        $this->categoryDAM = new CategoryDAM();
        $this->errorMsg = '';
        $this->featuredProductIds = array(1, 4, 8);
        $this->products = array();
        $this->product = '';
        $this->category = '';
		$this->categories = $this->categoryDAM->readCategories();
    }

    public static function getFeaturedInstance() {
        $vm = new self();
        foreach ($vm->featuredProductIds as $productId) {
            $product = $vm->productDAM->readProduct($productId);

            // Add product to array
            $vm->products[] = $product;
        }
        return $vm;
    }
	
    /**
     * Returns a vm object containing the product categories - used to support categories in the nav area
     * of views that don't have any other product information.
     * @return ProductsVM a view model object
     */
	public static function getCategoriesInstance() {
        $vm = new self();
        return $vm;
    }
    
    /**
     * Used to support views that list products in a particular category
     * @param int $deletedProductCategoryId the category to be listed
     * @return ProductsVM a view model object containing the products in the specified category
     */
    public static function getCategoryInstance($selectedCategoryId = null) {
        $vm = new self();
        if ($selectedCategoryId === null) {
        	$categoryId = filter_input(INPUT_POST, 'categoryId');
            if ($categoryId === null) {
            	$categoryId = filter_input(INPUT_GET, 'categoryId');
            }
        } else {
            $categoryId = $selectedCategoryId;
        }
        
        if ($categoryId === null) {
            $categoryId = 1;
        }
        $vm->products = $vm->productDAM->readProductsByCategoryId($categoryId);
        $vm->category = $vm->categoryDAM->readCategory($categoryId);
        return $vm;
    }
    
    /**
     * Supprots views that display a single product listing
     * @return ProductsVM a view model object containing information on a single product listing
     */
    public static function getProductInstance() {
        $vm = new self();
        $productId = filter_input(INPUT_GET, 'productId');
        $vm->product = $vm->productDAM->readProduct($productId);
        $vm->storeName = $vm->productDAM->readProductStore($productId);
        return $vm;
    }
    
    /**
     * Supports views that display a form to edit a product.
     * @return ProductsVM a view model object with information for a single product to be edited.
     */
    public static function getEditProductInstance() {
        $vm = new self();
        $productId = filter_input(INPUT_POST, 'productId');
        $vm->product = $vm->productDAM->readProduct($productId);
        return $vm;
    }
    
    public static function getDeleteInstance() {
        $vm = new self();
        $productId = filter_input(INPUT_POST, 'productId');
        $categoryId = filter_input(INPUT_POST, 'categoryId');
        $vm->productDAM->deleteProductById($productId);
        $vm->category = $vm->categoryDAM->readCategory($categoryId);
        return $vm;
    }
    
    public static function getAddEditInstance() {
        $vm = new self();
        
        // The userId for a prodcut should be obtained from the session data. However, in this version,
        // sessions are not implemented. Therefore, always set the user ID to the guitarShop user ID (1).
        // Also, the file upload is not implemented in this version.
        $userId = 1; // This should come from the session data in the final version.
        $imageFilename = 'noFile'; // This should come from the file upload code in the final version.
        $productId = filter_input(INPUT_POST,'productId');
        $varArray = array('id' => $productId,
        	'categoryId' => filter_input(INPUT_POST,'categoryId'),
        	'userId' => $userId,
        	'name' => filter_input(INPUT_POST, 'name'),
        	'listPrice' => filter_input(INPUT_POST,'price'),
        	'discountPercent' => filter_input(INPUT_POST, 'discountPercent'),
        	'description' => filter_input(INPUT_POST, 'description'),
        	'imageFilename' => $imageFilename);
        $vm->product = new Product($varArray);
        $vm->category = $vm->categoryDAM->readCategory($vm->product->categoryId);
        $vm->productDAM->writeProduct($vm->product);
        return $vm;
    }
}
