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
        
        $varArray = array('email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
        		'lastName' => filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS),
        		'firstName' => filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS),
        		'phoneNumber' => filter_input(INPUT_POST, 'phoneNumber'));
        $vm->newUser = new User($varArray);
        $vm->enteredPW = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $vm->enteredConfPW = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_SPECIAL_CHARS);
        if ($vm->validateUserInput()) {
            $vm->registrationType = self::VALID_REGISTRATION;
        }
        return $vm;
    }
      
    private function validateUserInput() {
        $success = false;
		
    // Add validation code here. 
    // If all validation tests pass, set $success = true. 
    if ($this->newUser->lastName == null) { 
        $this->errorMsg = 'Last name cannot be blank.'; 
    } else if ($this->newUser->firstName == null) { 
        $this->errorMsg = 'First name cannot be blank.'; 
    } else if ($this->newUser->email == null) { 
        $this->errorMsg = 'A valid email address is required.'; 
    } else if ($this->newUser->phoneNumber == null) { 
        $this->errorMsg = 'Phone number cannot be blank.'; 
    } else if (!preg_match('/[2-9]\d{2}-\d{3}-\d{4}/', $this->newUser->phoneNumber)) { 
        $this->errorMsg = 'A valid phone number is required. Ex: ###-###-####'; 
//  } else if ($this->newUser->storeName == null) { 
//      $this->errorMsg = 'A store name is required.'; 
    } else if ($this->enteredPW == null) { 
        $this->errorMsg = 'Password required.';
//  } else if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{11,}$/', $this->newUser->enteredPW)) { 
//      $this->errorMsg = 'Password does not meet reqs. aA-zZ, !@#$%^*(), 0-9, Length > 12';
    } else if ($this->enteredConfPW == null) {
        $this->errorMsg = 'Password confirmation required.';
//  } else if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{11,}$/', $this->newUser->enteredConfPW)) { 
//      $this->errorMsg = 'Password does not meet reqs. aA-zZ, !@#$%^*(), 0-9, Length > 12';
    } else if ($this->enteredConfPW != $this->enteredPW) { 
        $this->errorMsg = 'Password and confirmation password are different.'; 
    } else { 
        $success = true; 
    } 
    return $success; 
} 
}
