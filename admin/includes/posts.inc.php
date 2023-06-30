<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // grab submitted data from the form
    $postAuthor = filter_var($_POST["postAuthor"], FILTER_SANITIZE_SPECIAL_CHARS);
    $postCategory = filter_var($_POST["postCategory"], FILTER_SANITIZE_SPECIAL_CHARS);
    $postTitle = filter_var($_POST["postTitle"], FILTER_SANITIZE_SPECIAL_CHARS);
    $postContent = $_POST["postContent"];

    // Check if the 'is_featured' checkbox is checked.
    $isFeatured = 0;
    if (isset($_POST["is_featured"])) {
        $isFeatured = 1;
    }
    
    // Link the necessary files
    include "../classes/dbh.classes.php";
    include "../classes/posts.classes.php";
    include "../classes/posts-contr.classes.php";

    // instantiate
    $postInfo = new PostsContr($postAuthor, $postCategory, $postTitle, $postContent);

    // Check if a file was uploaded
    if(!empty($_FILES['featuredImage']['name'])) {
        // get the file name for featured image
        $fileName = $_FILES['featuredImage']['name'];
        $sanitizedFileName = time(). '_' . pathInfo($fileName, PATHINFO_FILENAME) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

        // specify the target directory to store the uploaded file
        $targetDirectory = "./../img/";
        $targetFilePath = $targetDirectory . $sanitizedFileName;

        // Validate and sanitize the file type
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            session_start();
            $_SESSION['postError'] = "Extension of uploaded file is not acceptable.";
            header("location: ../addpost.php");
            exit();
        }

        // Move the uploaded file
        if (move_uploaded_file($_FILES['featuredImage']['tmp_name'], $targetFilePath)) {
            $postInfo->setFeaturedImage($sanitizedFileName);
        } else {
            session_start();
            $_SESSION['postError'] = "File upload failed.";
            header("location: ../addpost.php");
            exit();
        }
    } else {
        $sanitizedFileName = '';
    }

    $postInfo->createPost($isFeatured);

    header("location: ../posts.php");
    exit();

}