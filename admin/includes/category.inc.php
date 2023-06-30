<?php
// start session
session_start();

if($_SERVER["REQUEST_METHOD"] = "POST") {
    // grab submitted data from the form
    $category = htmlspecialchars($_POST["category"], ENT_QUOTES, 'UTF-8');

    // Validate the input value
    if(empty($category)) {
        $_SESSION['categoryError'] = "Category name is required.";
        header("location: ../categories.php");
        exit();
    }

    // clear any existing error messages
    unset($_SESSION['categoryError']);


    // link required files
    include "../classes/dbh.classes.php";
    include "../classes/categories.classes.php";
    include "../classes/categories-contr.classes.php";

    // instantiate
    $categories = new CategoryContr($category);

    $categories->createCategory();

    // if successful, redirect to categories page
    header("location: ../categories.php");
}