<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //required files
    include "./../classes/dbh.classes.php";
    include "./../classes/posts.classes.php";
    include "./../classes/posts-view.classes.php";

    foreach ($_POST as $key => $value) {
        // check if the key starts with 'checkbox-'
        if (strpos($key, 'checkbox-') === 0) {
            // extract page Id
            $postId = substr($key, strlen('checkbox-'));

            if (!empty($value)) {
                $deletePost = new PostsView($postId);
                $deletePost->deletePost($postId);
            }
        }
    }

    // redirect when successful
    header("location: ../posts.php");
}