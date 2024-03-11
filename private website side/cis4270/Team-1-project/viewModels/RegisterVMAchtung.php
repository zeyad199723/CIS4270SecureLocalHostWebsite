<?php

/**
 * View model for user registration functions.
 *
 * @author jam
 * @version 210307
 */
class RegisterVM {

    public $enteredPW;
    public $enteredConfPW;
    public $registrationType;
    public $errorMsg;
    public $statusMsg;
    public $newUser;
	public $categories;
	private $categoryDAM;
    
    // User type constants used for switching in the controller.
    const VALID_REGISTRATION = 'valid_registration';
    const INVALID_REGISTRATION = 'invalid_registration';
    
    public function __construct() {
		$this->categoryDAM = new CategoryDAM();
        $this->errorMsg = '';
        $this->statusMsg = array();
        $this->enteredPW = '';
        $this->enteredConfPW = '';
        $this->registrationType = self::INVALID_REGISTRATION;
        $this->newUser = null;
		$this->categories = $this->categoryDAM->readCategories();
    }

    public static function getInstance() {
        $vm = new self();
        
        $varArray = array('email' => filter_input(INPUT_POST, 'email'),
        		'lastName' => filter_input(INPUT_POST, 'lastName'),
        		'firstName' => filter_input(INPUT_POST, 'firstName'),
        		'phoneNumber' => filter_input(INPUT_POST, 'phoneNumber'));
        $vm->newUser = new User($varArray);
        $vm->enteredPW = filter_input(INPUT_POST, 'password');
        $vm->enteredConfPW = filter_input(INPUT_POST, 'confirmPassword');
        if ($vm->validateUserInput()) {
            $vm->registrationType = self::VALID_REGISTRATION;
        }
        return $vm;
    }
      
    private function validateUserInput() {
        $success = false;
		
        // Add validation code here.
		// If all validation tests pass, set $success = true.
        
        return $success;
    }
}
