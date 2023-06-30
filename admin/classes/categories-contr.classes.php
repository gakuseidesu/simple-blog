<?php
class CategoryContr extends Category {
    private $category;

    public function __construct($category) {
        $this->category = $category;
    }

    // Method to create a category
    public function createCategory() {
        // Error handler
        if($this->emptyInput() == false) {
            $_SESSION['categoryError'] = "Please fill in the required field.";
            header("location: ../categories.php");
            exit();
        }

        if($this->categoryTakenCheck() == false) {
            $_SESSION['categoryError'] = "This category already exist. Choose a different category name.";
            header("location: ../categories.php");
            exit();
        }

        // unset any existing error messages
        unset($_SESSION['categoryError']);

        $this->setCategory($this->category);
    }

    // Error handlers
    private function emptyInput() {
        $result;
        if(empty($this->category)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function categoryTakenCheck() {
        $result;
        if(!$this->checkCategory($this->category)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }
}