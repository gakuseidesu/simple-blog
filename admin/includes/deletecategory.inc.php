<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // link required files
    include "./../classes/dbh.classes.php";
    include "./../classes/categories.classes.php";
    include "./../classes/categories-view.classes.php";

    foreach ($_POST as $key => $value) {
        //check if the key starts with 'checkbox-'
        if (strpos($key, 'checkbox-') === 0) {
            //extract the category ID from the key
            $categoryId = substr($key, strlen('checkbox-'));

            if(!empty($value)) {
                $deleteCategory = new CategoryView($categoryId);

                $deleteCategory->deleteCategory($categoryId);
            }
        }
    }

    // if deletion is successful, then redirect
    header("location: ../categories.php");

}