<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // grab submitted data from the form
    $pagesId = filter_var($_POST["pagesId"], FILTER_SANITIZE_NUMBER_INT);
    $pagesTitle = filter_var($_POST["pagesTitle"], FILTER_SANITIZE_SPECIAL_CHARS);
    $pagesContent = $_POST["pagesContent"];
    //$pagesContent = htmlspecialchars(strip_tags($_POST["pagesContent"]), ENT_QUOTES, 'UTF-8');

    // link the necessary files
    include "../classes/dbh.classes.php";
    include "../classes/pages.classes.php";
    include "../classes/pages-contr.classes.php";

    $pagesInfo = new PagesContr($pagesTitle, $pagesContent, $pagesId);

    // If there are new images to upload, let's process them
    $uploadedImages = array('featuredImage', 'featuredImage2');

    foreach ($uploadedImages as $imageKey) {
        if (!empty($_FILES[$imageKey]['name'])) {
            // get the new file name
            $fileName = $_FILES[$imageKey]['name'];
            $sanitizedFileName = time() . '_' . pathInfo($fileName, PATHINFO_FILENAME) . '.' . pathInfo($fileName, PATHINFO_EXTENSION);

            // specify target directory
            $targetDirectory = "./../img/";
            $targetFilePath = $targetDirectory . $sanitizedFileName;

            // validate and sanitize file type
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
            $fileExtension = strtolower(pathInfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                session_start();
                $_SESSION['pagesError'] = "Uploaded file is not supported. jpg, jpeg, png, or gif only.";
                header("location: ../editpage.php?q=" . $pagesId);
                exit();
            }

            if (!move_uploaded_file($_FILES[$imageKey]['tmp_name'], $targetFilePath)) {
                session_start();
                $_SESSION['pagesError'] = "Failed to upload file.";
                header("location: ../editpage.php?q=" . $pagesId);
                exit();
            }

            if ($imageKey === 'featuredImage') {
                $pagesInfo->setFeaturedImage($sanitizedFileName);
            } elseif ($imageKey === 'featuredImage2') {
                $pagesInfo->setFeaturedImage2($sanitizedFileName);
            } 
        }
    }

    // execute edit page
    $pagesInfo->editPage($pagesId);

    header("location: ../pages.php");
    exit();
}