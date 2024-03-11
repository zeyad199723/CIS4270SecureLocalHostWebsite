<?php

/**
 * User model data access and manipulation (DAM) class.
 *
 * @author jam
 * @version 210307
 */
class UserDAM extends DAM {

    function __construct() {
        parent::__construct();
    }

    public function readUser($userEmail) {
        $query = 'SELECT * FROM users WHERE emailAddress = :userEmail';
        $statement = $this->db->prepare($query);
        $statement->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
        $statement->execute();
        $productDB = $statement->fetch();
        $statement->closeCursor();
        if ($productDB == null) {
            return null;
        } else {
            $newUser = new User($this->mapColsToVars($productDB));
            return $newUser;
        }
    }

    public function writeUser($user) {
        if($user->id === null) {
            $query = 'INSERT INTO users
                        (emailAddress, lastName, firstName, phoneNumber, storeName,
                         shipAddressID, billingAddressID, password)
                      VALUES
                        (:email, :lastName, :firstName, :phoneNumber, :storeName, :addressId, :billingAddressId, :password)';
        } else {
            $query = 'UPDATE users
                      SET emailAddress = :email,
                          lastName = :lastName,
                          firstName = :firstName,
                          phoneNumber = :phoneNumber,
                          storeName = :storeName,
                          shipAddressID = :addressId,
                          billingAddressID = :billingAddressId,
                          password = :password
                      WHERE userID = :id';
        }
    
        $statement = $this->db->prepare($query);
        $params = [
            ':email' => $user->email,
            ':lastName' => $user->lastName,
            ':firstName' => $user->firstName,
            ':phoneNumber' => $user->phoneNumber,
            ':storeName' => $user->storeName,
            ':addressId' => $user->addressId,
            ':billingAddressId' => $user->billingAddressId,
            ':password' => $user->password
        ];
    
        if ($user->id !== null) {
            $params[':id'] = $user->id;
        }
    
        $statement->execute($params);
        $statement->closeCursor();
    }
    

    public function deleteUser($user) {
        $this->deleteUserById($user->id);
    }

    public function deleteUserById($userId) {
        $query = 'DELETE FROM users WHERE userID = :userID';
        $statement = $this->db->prepare($query);
        $statement->bindParam(':userID', $userId, PDO::PARAM_INT);
        $statement->execute();
        $statement->closeCursor();
    }

    private function mapColsToVars($colArray) {
		$varArray = array ();
		foreach ( $colArray as $key => $value ) {
			if ($key == 'userID') {
				$varArray ['id'] = $value;
			} else if ($key == 'emailAddress') {
				$varArray ['email'] = $value;
			} else if ($key == 'lastName') {
				$varArray ['lastName'] = $value;
			} else if ($key == 'firstName') {
				$varArray ['firstName'] = $value;
			} else if ($key == 'phoneNumber') {
				$varArray ['phoneNumber'] = $value;
			} else if ($key == 'storeName') {
				$varArray ['storeName'] = $value;
			} else if ($key == 'shipAddressID') {
				$varArray ['addressId'] = $value;
			} else if ($key == 'billingAddressID') {
				$varArray ['billingAddressId'] = $value;
			} else if ($key == 'password') {
				$varArray ['password'] = $value;
			}
		}
		return $varArray;
	}
}