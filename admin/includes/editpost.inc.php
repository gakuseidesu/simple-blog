<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // grab submitted data from the form
    $postId = filter_var($_POST["postId"], FILTER_SANITIZE_NUMBER_INT);
    $postAuthor = filter_var($_POST["postAuthor"], FILTER_SANITIZE_SPECIAL_CHARS);
    $postCategory = filter_var($_POST["postCategory"], FILTER_SANITIZE_SPECIAL_CHARS);
    $postTitle = filter_var($_POST["postTitle"], FILTER_SANITIZE_SPECIAL_CHARS);
    $postContent = $_POST["postContent"];

    // Check if the 'is_featured' checkbox is checked
    $isFeatured = 0;
    if (isset($_POST["is_featured"])) {
        $isFeatured = 1;
    }

    // Link the necessary files
    include "../classes/dbh.classes.php";
    include "../classes/posts.classes.php";
    include "../classes/posts-contr.classes.php";

    // instantiate
    $postInfo = new PostsContr($postAuthor, $postCategory, $postTitle, $postContent, $postId);

    // Check if a new featured image was uploaded
    if (!empty($_FILES['featuredImage']['name'])) {
        // get the file name for the featured image
        $fileName = $_FILES['featuredImage']['name'];
        $sanitizedFileName = time(). '_' . pathInfo($fileName, PATHINFO_FILENAME) . '.' . pathInfo($fileName, PATHINFO_EXTENSION);

        // specify the target directory to store the uploaded file
        $targetDirectory = "./../img/";
        $targetFilePath = $targetDirectory . $sanitizedFileName;

        // Validate and sanitize the file type
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        $fileExtension = strtolower(pathInfo($fileName, PATHINFO_EXTENSION));
        if(!in_array($fileExtension, $allowedExtensions)) {
            session_start();
            $_SESSION['postError'] = "Extension of uploaded file is not acceptible. jpg, jpeg, png, or gif only.";
            header("location: ../editpost.php");
            exit();
        }

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($_FILES['featuredImage']['tmp_name'], $targetFilePath)) {
            session_start();
            $_SESSION['postError'] = "Failed to move uploaded file.";
            header("location: ../editpost.php");
            exit();
        }

        // Set the new featured image file name in the object
        $postInfo->setFeaturedImage($sanitizedFileName);
    }

    // execute editPost()
    $postInfo->editPost($isFeatured, $postId);

    header("location: ../posts.php");
    exit();
}