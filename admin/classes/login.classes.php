<?php
class Login extends Dbh {

    // method for login
    protected function getUser($email, $pwd) {
        $stmt = $this->connect()->prepare('SELECT pwd FROM users WHERE email = ? OR pwd = ?;');

        // execute sql statement
        if(!$stmt->execute(array($email, $pwd))) {
            $stmt = null;
            session_start();
            $_SESSION['errorLoginFailed'] = "Login failed.";
            header("location: ../login.php");
            exit();
        }

        // check if there are any rows returned
        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['errorUserNotFound'] = "User not found";
            header("location: ../login.php");
            exit();
        }

        // Check if passwords are correct
        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($pwd, $pwdHashed[0]["pwd"]);

        if($checkPwd == false) {
            $stmt = null;
            session_start();
            $_SESSION['errorWrongPwd'] = "Password incorrect.";
            header("location: ../login.php");
            exit();
        } elseif($checkPwd == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE email = ? OR pwd = ?;');

            if(!$stmt->execute(array($email, $pwd))) {
                $stmt = null;
                session_start();
                $_SESSION['errorLoginFailed'] = "Login failed.";
                header("location: ../login.php");
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = null;
                session_start();
                $_SESSION['errorUserNotFound'] = "User not found.";
                header("location: ../login.php");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["simpleBlog_userid"] = $user[0]["id"];
            $_SESSION["simpleBlog_userName"] = $user[0]["username"];
            $_SESSION["isLoggedInToSimpleBlog"] = true;

            $stmt = null;
        }

    }

}