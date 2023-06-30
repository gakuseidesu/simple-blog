<?php
class PasswordValidator {
    private $pwd;
    private $errors = [];

    public function __construct($pwd) {
        $this->pwd = $pwd;
    }

    public function validatePwd() {
        if(strlen($this->pwd < 8) && strlen($this->pwd > 20)) {
            $this->errors[] = "Password must be between 8 and 20 characters long.";
        }

        if(!preg_match("/[A-Z]/", $this->pwd)) {
            $this->errors[] = "Password must contain at least one uppercase letter.";
        }

        if(!preg_match("/[a-z]/", $this->pwd)) {
            $this->errors[] = "Password must contain at least one lowercase letter.";
        }

        if(!preg_match("/[0-9]/", $this->pwd)) {
            $this->errors[] = "Password must contain at least one digit.";
        }

        if(!preg_match("/[^a-zA-Z0-9]/", $this->pwd)) {
            $this->errors[] = "Password must contain at least one special character.";
        }

        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
}