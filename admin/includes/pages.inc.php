<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // grab submitted data from the form
    $pagesTitle = filter_var($_POST["pagesTitle"], FILTER_SANITIZE_SPECIAL_CHARS);
    $pagesContent = $_POST["pagesContent"];
    //$pagesContent = htmlspecialchars(strip_tags($_POST["pagesContent"]), ENT_QUOTES, 'UTF-8');

    // Link the necessary files
    include "../classes/dbh.classes.php";
    include "../classes/pages.classes.php";
    include "../classes/pages-contr.classes.php";

    $pagesInfo = new PagesContr($pagesTitle, $pagesContent);

    // Process the featuredImage and featuredImage2 uploads
    $fileInputs = array('featuredImage', 'featuredImage2');

    foreach ($fileInputs as $fileInputName) {
        if(!empty($_FILES[$fileInputName]['name'])) {
            $fileName = $_FILES[$fileInputName]['name'];
            $sanitizedFileName = time(). '_' . pathInfo($fileName, PATHINFO_FILENAME) . '.' . pathInfo($fileName, PATHINFO_EXTENSION);

            $targetDirectory = "./../img/";
            $targetFilePath = $targetDirectory . $sanitizedFileName;

            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
            $fileExtension = strtolower(pathInfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                session_start();
                $_SESSION['pagesError'] = "Uploaded file is not acceptable. jpg, jpeg, png, or gif only.";
                header("location: ../addpage.php");
                exit();
            }

            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetFilePath)) {
                if ($fileInputName === 'featuredImage') {
                    $pagesInfo->setFeaturedImage($sanitizedFileName);
                } elseif ($fileInputName === 'featuredImage2') {
                    $pagesInfo->setFeaturedImage2($sanitizedFileName);
                }
            } else {
                session_start();
                $_SESSION['pagesError'] = "File upload failed.";
                header("location: ../addpage.php");
                exit();
            }
        }
    }

    $pagesInfo->createPage();

    header("location: ../pages.php");
    exit();
}