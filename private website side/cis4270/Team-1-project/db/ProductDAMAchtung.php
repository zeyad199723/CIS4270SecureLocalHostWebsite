<?php

/**
 * Product model data access and manipulation (DAM) class.
 * This version is vulnerable to SQL injection.
 *
 * @author jam
 * @version 210307
 */
class ProductDAM extends DAM {

	// Database connection is inherited from the parent.
	function __construct() {
		parent::__construct ();
	}

	/**
	 * Read the Product object from the database with the specified ID
	 *
	 * @param int $productID
	 *        	the ID of the product to be read.
	 * @return NULL|Product the resulting Product object - null if product is
	 *         not in the database.
	 */
	public function readProduct($productID) {
		$query = 'SELECT * FROM products
              WHERE productID = \'' . $productID . '\'';
		$statement = $this->db->prepare ( $query );
		$statement->execute ();
		$productDB = $statement->fetch ();
		$statement->closeCursor ();
		if ($productDB == null) {
			return null;
		} else {
			return new Product ( $this->mapColsToVars ( $productDB ) );
		}
	}

	/**
	 * Read all the Product objects in the database.
	 *
	 * @return Product[] an array of Product objects.
	 */
	public function readProducts() {
		$query = 'SELECT * FROM products
              ORDER BY productID';
		$statement = $this->db->prepare ( $query );
		$statement->execute ();
		$productsDB = $statement->fetchAll ();
		$statement->closeCursor ();

		// Build an array of Product objects
		$products = array ();
		foreach ( $productsDB as $key => $value ) {
			$products [$key] = new Product ( $this->mapColsToVars ( $productsDB [$key] ) );
		}
		return $products;
	}
	
	/**
	 * Read the name of the store selling the product with the specified product ID.
	 * @param int $productID the ID of the product in question
	 * @return NULL|string the name of the store selling the product.
	 */
	public function readProductStore($productID) {
		$query = 'SELECT storeName
              FROM products INNER JOIN users ON users.userID = products.userID
              WHERE productID = \'' . $productID . '\'';
		$statement = $this->db->prepare ($query);
		$statement->execute ();
		$storeNameDB = $statement->fetch ();
		$statement->closeCursor ();
		if ($storeNameDB == null) {
			return null;
		} else {
			return $storeNameDB[0];
		}
	}

	/**
	 * Read all the Product objects in the database with the specified
	 * categoryID.
	 *
	 * @param int $categoryID
	 *        	the ID of the product category to be read.
	 * @return Product[] an array of Product objects.
	 */
	public function readProductsByCategoryId($categoryID) {
		$query = 'SELECT * FROM products
              WHERE categoryID = \'' . $categoryID . '\'
              ORDER BY productID';
		$statement = $this->db->prepare ( $query );
		$statement->execute ();
		$productsDB = $statement->fetchAll ();
		$statement->closeCursor ();

		// Build an array of Product objects
		$products = array ();
		foreach ( $productsDB as $key => $value ) {
			$products [$key] = new Product ( $this->mapColsToVars ( $productsDB [$key] ) );
		}
		return $products;
	}

	/**
	 * Write the specified product to the database.
	 * If the product is not
	 * in the database, the object is added. If the product is already in the
	 * database, the object is updated.
	 *
	 * @param Product $product
	 *        	the Product object to be written.
	 */
	public function writeProduct($product) {
		if($product->id === null) {
		
			// Add a new product to the database
			$query = 'INSERT INTO products
                (categoryID, userID, productName,
                 description, listPrice, discountPercent, imageFilename)
              VALUES
                (\'' . $product->categoryId . '\', \'' . $product->userId . '\', \''
                . $product->name . '\', \'' . $product->description . '\', \''
                . $product->listPrice . '\', \'' . $product->discountPercent . '\', \''
                . $product->imageFilename .	'\')';
			$statement = $this->db->prepare ( $query );
			$statement->execute ();
			$statement->closeCursor ();
		} else {

			// Update an existing Product.
			$query = 'UPDATE products
              SET userID = \'' . $product->userId . '\',
                  productName = \'' . $product->name . '\',
                  listPrice = \'' . $product->listPrice . '\',
                  discountPercent = \'' . $product->discountPercent . '\',
                  categoryID = \'' . $product->categoryId . '\',
                  description = \'' . $product->description . '\',
	              imageFilename = \'' . $product->imageFilename . '\'
              WHERE productID = \'' . $product->id . '\'';

			$statement = $this->db->prepare ( $query );
			$statement->execute ();
			$statement->closeCursor ();
		}
	}

	/**
	 *  the specified Product object from the database.
	 *
	 * @param Product $product
	 *        	the Product object to be deleted.
	 */
	public function deleteProduct($product) {
		$this->deleteProductById ( $product->id );
	}

	/**
	 * Delete the Product object from the database with the specified ID.
	 *
	 * @param int $productID
	 *        	the ID of the Product to be deleted.
	 */
	public function deleteProductById($productID) {
		$query = 'DELETE FROM products WHERE productID = \'' . $productID . '\'';
		$statement = $this->db->prepare ( $query );
		$statement->execute ();
		$statement->closeCursor ();
	}

	// Translate database columnames to object instance variable names
	private function mapColsToVars($colArray) {
		$varArray = array ();
		foreach ( $colArray as $key => $value ) {
			if ($key == 'productID') {
				$varArray ['id'] = $value;
			} else if ($key == 'categoryID') {
				$varArray ['categoryId'] = $value;
			} else if ($key == 'userID') {
				$varArray ['userId'] = $value;
			} else if ($key == 'productName') {
				$varArray ['name'] = $value;
			} else if ($key == 'description') {
				$varArray ['description'] = $value;
			} else if ($key == 'listPrice') {
				$varArray ['listPrice'] = $value;
			} else if ($key == 'discountPercent') {
				$varArray ['discountPercent'] = $value;
			} else if ($key == 'imageFilename') {
				$varArray ['imageFilename'] = $value;
			}
		}
		return $varArray;
	}
}
