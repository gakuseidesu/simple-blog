<?php
    session_start();

    // Check if user is logged in. If not, then redirect to login
    if(!isset($_SESSION["isLoggedInToSimpleBlog"]) && $_SESSION["isLoggedInToSimpleBlog"] != "true") {
        header("Location: login.php");
        exit();
    }

    // Checks for session postErrors
    if(isset($_SESSION['postError'])) {
        $postError = $_SESSION['postError'];

        // Clear the postError session variable after reload of form
        unset($_SESSION['postError']);
    }

    // Link necessary files
    include "classes/dbh.classes.php";
    include "classes/categories.classes.php";
    include "classes/categories-view.classes.php";
    include "classes/posts.classes.php";
    include "classes/posts-view.classes.php";
    
    $categoryInfo = new CategoryView();
    $postInfoToEdit = new PostsView();


    $categoryDetails = $categoryInfo->fetchCategory();
    

    // get the post id
    $postId = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_NUMBER_INT);
    
    $pageTitle = 'Posts';

    include "templates/header.php";
?>
<div class="container px-0 py-5 min-vh-100">
    <div class="row border-bottom pb-2 mb-5">
        <div class="col-sm-12 col-md-10 mx-auto">
            <h3>Edit Post</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-10 mx-auto">
            <?php if(isset($postError)): ?> 
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($postError, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>
            <form action="includes/editpost.inc.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 col-md-6 mb-3">
                        <select name="postAuthor" id="postAuthor" class="form-select" aria-label="post author select">
                            <option value="<?php echo htmlspecialchars($postInfoToEdit->fetchPostAuthor($postId)); ?>" selected>
                                    <?php echo htmlspecialchars($postInfoToEdit->fetchPostAuthor($postId)); ?>
                                </option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6 mb-3">
                        <select name="postCategory" id="postCategory" class="form-select" aria-label="post category select">
                            <option value="<?php echo htmlspecialchars($postInfoToEdit->fetchPostCategory($postId)); ?>">
                                    <?php echo htmlspecialchars($postInfoToEdit->fetchPostCategory($postId)); ?>
                                </option>
                        </select>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="postTitle" id="postTitle" class="form-control" placeholder="Add Title" value="<?php echo htmlspecialchars($postInfoToEdit->fetchPostTitle($postId), ENT_QUOTES, 'UTF-8'); ?>">
                    <label for="postTitle">Edit Title</label>
                </div>
                <div class="my-3">
                    <?php 
                        $retrievedContent = htmlspecialchars($postInfoToEdit->fetchPostContent($postId), ENT_QUOTES, 'UTF-8');
                        $retrievedContent = str_replace('</p>', '</p><br>', $retrievedContent);
                        echo "<textarea class='form-control' name='postContent' id='postContent' cols='30' rows='10'>" . $retrievedContent . "</textarea>";
                    ?>
                </div>
                <div class="my-3">
                    <?php
                        $currentFeaturedImage = $postInfoToEdit->fetchPostFeaturedImage($postId);
                        echo "Current Featured Image: " . htmlspecialchars($currentFeaturedImage, ENT_QUOTES, 'UTF-8') . "</br>";
                    ?>
                    <label for="featuredImage">Upload a new image here to replace your current featured image:</label>
                    <input type="file" name="featuredImage" id="featuredImage" class="form-control">
                </div>
                <div class="form-check form-switch my-3">
                    <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" role="switch" 
                    <?php
                        $postIsFeatured = $postInfoToEdit->isThePostFeatured($postId);
                        if ($postIsFeatured == 1) {
                            echo "checked";
                        }
                    ?>
                    >
                    <label for="is_featured" class="form-check-label">
                        Make this a featured post
                    </label>
                </div>
                <div class="my-3">
                    <input type="hidden" name="postId" value="<?php echo htmlspecialchars($postId, ENT_QUOTES, 'UTF-8'); ?>">
                    <button type="submit" class="btn btn-primary" name="submit">Edit Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "templates/footer.php"; ?>