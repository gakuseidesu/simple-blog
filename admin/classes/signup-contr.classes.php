<?php
class SignupContr extends Signup {
    private $userName;
    private $email;
    private $pwd;
    private $pwdRepeat;

    public function __construct($userName, $email, $pwd, $pwdRepeat) {
        $this->userName = $userName;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
    }

    public function signupUser() {
        // Error handlers
        if($this->emptyInput() == false) {
            session_start();
            $_SESSION['errorEmpty'] = "Please fill in all of the fields.";
            header("location: ../registration.php");
            exit();
        }

        if($this->invalidUsername() == false) {
            session_start();
            $_SESSION['errorUsername'] =  "Username is invalid. Username must be at least 4 characters long and alphanumeric";
            header("location: ../registration.php");
            exit();
        }

        if($this->invalidEmail() == false) {
            session_start();
            $_SESSION['errorEmail'] = "Please use a valid email address.";
            header("location: ../registration.php");
            exit();
        }

        if($this->pwdMatch() == false) {
            session_start();
            $_SESSION['errorPwdMatch'] = "Passwords inputted does not match.";
            header("location: ../registration.php");
            exit();
        }

        // Validate passwords entered and generate errors, if any
        include "password-validator.classes.php";
        $pwdValidator = new PasswordValidator($this->pwd);
        if(!$pwdValidator->validatePwd()) {
            $errors = $pwdValidator->getErrors();
            session_start();
            foreach($errors as $error) {
                $_SESSION['errorPwd'] = $error;
            }
            header("location: ../registration.php");
            exit();
        }

        if($this->emailTakenCheck() == false) {
            session_start();
            $_SESSION['emailTaken'] = "The email you entered is already taken.";
            header("location: ../registration.php");
            exit();
        }

        // If there are no errors, then proceed with the sign up
        $this->setUser($this->userName, $this->pwd, $this->email);
    }

    // Error handlers
    private function emptyInput() {
        $result;
        if(empty($this->userName) || empty($this->email) || empty($this->pwd) || empty($this->pwdRepeat)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function invalidUsername() {
        $result;
        if(!preg_match("/^[a-zA-Z0-9_]+$/", $this->userName) && $this->userName < 4) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    // Checks for a valid email address
    private function invalidEmail() {
        $result;
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    // Password validation method
    private function pwdMatch() {
        if($this->pwd !== $this->pwdRepeat) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    // Checks to see if the username is already taken
    private function emailTakenCheck() {
        $result;
        if(!$this->checkUser($this->email)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

}