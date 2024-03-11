<?php

/**
 * User model data access and manipulation (DAM) class.
 *
 * @author jam
 * @version 210307
 */
class UserDAM extends DAM {

	// Database connection is inherited from the parent.
	function __construct() {
		parent::__construct ();
	}

	/**
	 * Read the User object from the database with the specified ID
	 *
	 * @param string $userEmail
	 *        	the user's unique user email
	 * @return NULL|User the resulting User object - null if user is
	 *         not in the database.
	 */
	public function readUser($userEmail) {
		$query = 'SELECT * FROM users
              WHERE emailAddress = \'' . $userEmail . '\'';
		$statement = $this->db->prepare ( $query );
		$statement->execute ();
		$productDB = $statement->fetch ();
		$statement->closeCursor ();
		if ($productDB == null) {
			return null;
		} else {
			return new User ( $this->mapColsToVars ( $productDB ) );
		}
	}

	/**
	 * Write the specified user to the database.
	 * If the user is not
	 * in the database, the object is added. If the user is already in the
	 * database, the object is updated (excluding password).
	 *
	 * @param User $user
	 *        	the User object to be written.
	 */
	public function writeUser($user) {
		if($user->id === null) {
		
			// Add a new user to the database
			$query = 'INSERT INTO users
                (emailAddress, lastName, firstName, phoneNumber, storeName,
                 shipAddressID, billingAddressID, password)
              VALUES
                (\'' . $user->email . '\', \'' . $user->lastName . '\', \'' . $user->firstName . '\', \''
                . $user->phoneNumber . '\', \'' . $user->storeName . '\', \'' . $user->addressId . '\', \''
                . $user->billingAddressId . '\', \'' . $user->password . '\')';
			$statement = $this->db->prepare ( $query );
			$statement->execute ();
			$statement->closeCursor ();
		} else {

			// Update an existing user.
			$query = 'UPDATE users
              SET emailAddress = \'' . $user->emailAddress . '\',
                  lastName = \'' . $user->lastName . '\',
                  firstName = \'' . $user->firstName . '\',
                  phoneNumber = \'' . $user->phoneNumber . '\',
                  storeName = \'' . $user->storeName . '\',
                  shipAddressID = \'' . $user->addressId . '\',
	              billingAddressID = \'' . $user->billingAddressId . '\'
                  password = \'' . $user->password . '\'
              WHERE userID = \'' . $user->id . '\'';
			$statement = $this->db->prepare ( $query );
			$statement->execute ();
			$statement->closeCursor ();
		}
	}

	/**
	 * Delete the specified User object from the database.
	 * @param User $user the User object to be deleted.
	 */
	public function deleteUser($user) {
		$this->deleteUserById ( $user->id );
	}

	/**
	 * Delete the User object from the database with the specified ID.
	 * @param string $userId the ID of the User to be deleted
	 */
	public function deleteUserById($userId) {
		$query = 'DELETE FROM users
              WHERE userID = :userID';
		$statement = $this->db->prepare ( $query );
		$statement->bindValue ( ':userID', $userId );
		$statement->execute ();
		$statement->closeCursor ();
	}

	// Translate database columnames to object instance variable names
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
