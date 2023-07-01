<?php
class Login extends Dbh {

    // method for login
    protected function getUser($email, $pwd) {
        $stmt = $this->connect()->prepare('SELECT pwd FROM users WHERE email = ? OR pwd = ?;');
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $pwd);

        // execute sql statement
        if(!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION['loginErrors'] = "Login failed. Error: " . $errorInfo[2];
            header("location: ../login.php");
            exit();
        }

        // check if there are any rows returned
        if($stmt->rowCount() == 0) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION['loginErrors'] = "User not found. Error: " . $errorInfo[2];
            header("location: ../login.php");
            exit();
        }

        // Check if passwords are correct
        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($pwd, $pwdHashed[0]["pwd"]);

        if($checkPwd == false) {
            session_start();
            $_SESSION['loginErrors'] = "Password incorrect.";
            header("location: ../login.php");
            exit();
        } elseif($checkPwd == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE email = ? OR pwd = ?;');
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $pwd);

            if(!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();
                session_start();
                $_SESSION['loginErrors'] = "Login failed. Error: " . $errorInfo[2];
                header("location: ../login.php");
                exit();
            }

            if($stmt->rowCount() == 0) {
                session_start();
                $_SESSION['loginErrors'] = "User not found.";
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