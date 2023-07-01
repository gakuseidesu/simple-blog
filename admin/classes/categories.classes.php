<?php
class Category extends Dbh {

    // Method for adding a category
    protected function setCategory($category) {
        $stmt = $this->connect()->prepare('INSERT INTO categories (cat_name) VALUES (:category);');
        $stmt->bindValue(':category', $category);


        if(!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION['categoryError'] = "Failed to create the category. Error: " . $errorInfo[2];
            header("location: ../categories.php");
            exit();
        }
    }

    // Method to check if a category exists
    protected function checkCategory($category) {
        $stmt = $this->connect()->prepare('SELECT cat_name FROM categories WHERE cat_name = :category;');
        $stmt->bindValue(':category', $category);

        if(!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION['categoryError'] = "Failed to check for duplicates. Error: " . $errorInfo[2];
            header("location: ../categories.php");
            exit();
        }

        // check results, if any.
        $resultCheck;
        if($stmt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

    // Method that gets the category id
    protected function getCategoryId() {
        $stmt = $this->connect()->prepare('SELECT id FROM categories;');

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION['categoryError'] = "Failed to get category id. Error: " . $errorInfo[2];
            header("location: ../categories.php");
            exit();
        }

        if ($stmt->rowCount() === 0) {
            session_start();
            $_SESSION['categoryError'] = "There are no category id found.";
            header("location: ../categories.php");
            exit();
        }

        $categoryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $categoryData;
    }

    // Method that gets the category name
    protected function getCategoryNameById($categoryId) {
        $stmt = $this->connect()->prepare('SELECT cat_name FROM categories WHERE id = ?;');
        $stmt->bindParam(1, $categoryId);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION['categoryError'] = "Failed to get category name. Error: " . $errorInfo[2];
            header("location: ../categories.php");
            exit();
        }

        if ($stmt->rowCount() === 0) {
            session_start();
            $_SESSION['categoryError'] = "There are no category name found.";
            header("location: ../categories.php");
            exit();
        }

        $categoryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $categoryData;
    }

    // Method that grabs the category info
    protected function getCategoryInfo() {
        $stmt = $this->connect()->prepare('SELECT * FROM categories;');

        // execute sql
        if(!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION['categoryError'] = "Statement failed to get all categories.";
            header("location: ../categories.php");
            exit();
        }

        if($stmt->rowCount() == 0) {
            session_start();
            $_SESSION['categoryError'] = "There are no categories to display.";
            header("location: ../categories.php");
            exit();
        }

        $categoryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $categoryData;
    }

    // Method that deletes a category
    protected function removeCategory($categoryId) {
        $stmt = $this->connect()->prepare('DELETE FROM categories WHERE id = :categoryId;');
        $stmt->bindValue(':categoryId', $categoryId);

        // execute sql
        if(!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            session_start();
            $_SESSION['categoryError'] = "Failed to delete the category. Error: " . $errorInfo[2];
            header("location: ../categories.php");
            exit();
        }

    }


}