<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //necessary files
    include "./../classes/dbh.classes.php";
    include "./../classes/pages.classes.php";
    include "./../classes/pages-view.classes.php";

    foreach ($_POST as $key => $value) {
        // check if the key starts with 'checkbox-'
        if (strpos($key, 'checkbox-') === 0) {
            // extract the page ID from the key
            $pagesId = substr($key, strlen('checkbox-'));

            if (!empty($value)) {
                $deletePage = new PagesView($pagesId);
                $deletePage->deletePage($pagesId);
            }
        }
    }

    // redirect when successful
    header("location: ../pages.php");
}