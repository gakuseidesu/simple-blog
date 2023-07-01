<?php
class LoginContr extends Login {

    private $email;
    private $pwd;

    public function __construct($email, $pwd) {
        $this->email = $email;
        $this->pwd = $pwd;
    }

    public function loginUser() {
        // error handler
        if($this->emptyInput() == false) {
            $_SESSION['loginErrors'] = "Please fill in all of the fields.";
            header("location: ../login.php");
            exit();
        }

        // Proceed with the login if there are no errors
        $this->getUser($this->email, $this->pwd);
    }

    // Error handler

    // Makes sure that all of the fields are filled in and not empty
    private function emptyInput() {
        $result;
        if(empty($this->email) || empty($this->pwd)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

}