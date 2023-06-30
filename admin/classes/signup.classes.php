<?php
class Signup extends Dbh {

    // method for registration
    protected function setUser($userName, $pwd, $email) {
        $stmt = $this->connect()->prepare('INSERT INTO users (username, pwd, email) VALUES (?, ?, ?);');

        // hash password
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        // execute sql
        if(!$stmt->execute(array($userName, $hashedPwd, $email))) {
            $stmt = null;
            header("location: ../registration.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    // method to check if user already exists
    protected function checkUser($email) {
        $stmt = $this->connect()->prepare('SELECT email FROM users WHERE email = ?;');

        // execute sql
        if(!$stmt->execute(array($email))) {
            $stmt = null;
            header("location: ../registration.php?error=stmtfailed");
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
            $stmt = null;
            session_start();
            $_SESSION['errorStmtFailed'] = "Failed to get user id.";
            header("location: ../registration.php");
            exit();
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['errorUserNotFound'] = "User id not found.";
            header("location: ../registration.php");
            exit();
        }

        $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $userData;
    }

}