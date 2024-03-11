<?php

/**
 * Category model data access and manipulation (DAM) class.
 * This version is vulnerable to SQL injection.
 *
 * @author jam
 * @version 180428
 */
class CategoryDAM extends DAM {

    function __construct() {
        parent::__construct();
    }

    public function readCategory($categoryID) {
        $query = 'SELECT * FROM categories WHERE categoryID = :categoryID';
        $statement = $this->db->prepare($query);
        $statement->bindParam(':categoryID', $categoryID, PDO::PARAM_INT);
        $statement->execute();
        $categoryDB = $statement->fetch();
        $statement->closeCursor();
        if ($categoryDB == null) {
            return null;
        } else {
            return new Category($this->mapColsToVars($categoryDB));
        }
    }

    public function readCategories() {
        $query = 'SELECT * FROM categories ORDER BY categoryID';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $categoriesDB = $statement->fetchAll();
        $statement->closeCursor();

        $categories = array();
        foreach ($categoriesDB as $key => $value) {
            $categories[$key] = new Category($this->mapColsToVars($categoriesDB[$key]));
        }
        return $categories;
    }

    private function mapColsToVars($colArray) {
        $varArray = array();
        foreach ($colArray as $key => $value) {
            if ($key == 'categoryID') {
                $varArray['id'] = $value;
            } else if ($key == 'categoryName') {
                $varArray['name'] = $value;
            }
        }
        return $varArray;
    }
}