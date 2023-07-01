<?php
class Signup extends Dbh {

    // method for registration
    protected function setUser($userName, $pwd, $email) {
        $stmt = $this->connect()->prepare('INSERT INTO users (username, pwd, email) VALUES (?, ?, ?);');

        // hash password
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        $stmt->bindParam(1, $userName);
        $stmt->bindParam(2, $hashedPwd);
        $stmt->bindParam(3, $email);

        // execute sql
        if(!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION["signupErrors"] = "Failed to insert details into the database. Error: " . $errorInfo[2];
            header("location: ../registration.php?error=stmtfailed");
            exit();
        }
    }

    // method to check if user already exists
    protected function checkUser($email) {
        $stmt = $this->connect()->prepare('SELECT email FROM users WHERE email = ?;');
        $stmt->bindParam(1, $email);

        // execute sql
        if(!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION["signupErrors"] = "Failed to check email for duplications. Error: " . $errorInfo[2];
            header("location: ../registration.php");
            exit();
        }

        // returned rows?
        $resultCheck;
        if($stmt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

    // Method that grabs the user id
    protected function getUserId($email) {
        $stmt = $this->connect()->prepare('SELECT id FROM users WHERE email = ?;');
        $stmt->bindValue(':email', $email);

        // execute sql
        if(!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION['signupErrors'] = "Failed to get user id. Error: " . $errorInfo[2];
            header("location: ../registration.php");
            exit();
        }

        if($stmt->rowCount() == 0) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION['signupErrors'] = "User id not found. Error: " . $errorInfo[2];
            header("location: ../registration.php");
            exit();
        }

        $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $userData;
    }

}