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
    private $userDAM;

    
    // User type constants used for switching in the controller.
    const VALID_REGISTRATION = 'valid_registration';
    const INVALID_REGISTRATION = 'invalid_registration';
    
    public function __construct() {
		$this->categoryDAM = new CategoryDAM();
        $this->userDAM = new UserDAM();
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
        
        $varArray = array('email' => emailPOST('email'),
      'lastName' => hPOST('lastName'),
      'firstName' => hPOST('firstName'),
      'phoneNumber' => hPOST('phoneNumber'));
      
    $vm->newUser = new User($varArray);
    $vm->enteredPW = hPOST('password');
    $vm->enteredConfPW = hPOST('confirmPassword');
        if ($vm->validateUserInput()) {
            $vm->newUser->password
        = password_hash($vm->enteredPW, PASSWORD_DEFAULT);
 $vm->userDAM->writeUser($vm->newUser);
            $vm->registrationType = self::VALID_REGISTRATION;
        }
        return $vm;
    }
      
    private function validateUserInput() {
        $success = true;
    
        // Validate email address.
        if (!emailPOST('email')) {
          $this->errorMsg = 'Invalid email address.';
          $success = false;
        }
    
        // Validate password.
        if (strlen($this->enteredPW) < 8) {
          $this->errorMsg = 'Password must be at least 8 characters long.';
          $success = false;
        }
    
        // Validate confirmed password.
        if ($this->enteredPW !== $this->enteredConfPW) {
          $this->errorMsg = 'Passwords must match.';
          $success = false;
        }
    
        // Validate phone number.
        $phoneNumber = hPOST('phoneNumber');
        if (!$this->isValidPhoneNumber($phoneNumber)) {
          $this->errorMsg = 'Invalid phone number.';
          $success = false;
        }
    
        return $success;
      }
    

public function getEmail() {
    return $this->newUser->getEmail();
  }

  public function getFirstName() {
    return $this->newUser->getFirstName();
  }

  public function getLastName() {
    return $this->newUser->getLastName();
  }

  public function isValidPhoneNumber($phoneNumber) {
    return preg_match('/^[0-9]{10}$/', $phoneNumber);
}

  public function getNewAccountInfo() {
    $info = [
      'email' => $this->getEmail(),
      'firstName' => $this->getFirstName(),
      'lastName' => $this->getLastName(),
      'phoneNumber' => $this->getPhoneNumber(),
    ];

    // Display the information in a list.
    $output = '<ul>';
    foreach ($info as $key => $value) {
      $output .= '<li>' . ucfirst($key) . ': ' . $value . '</li>';
    }
    $output .= '</ul>';

    return $output;
  }

  /**
   * Display the new account information.
   */
  public function displayNewAccountInfo() {
    if ($this->registrationType === self::VALID_REGISTRATION) {
      echo $this->getNewAccountInfo();
    } else {
      echo 'New account information could not be displayed.';
    }
  }
  }
