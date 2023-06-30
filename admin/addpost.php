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
        
        //clear the postError session variable
        unset($_SESSION['postError']);
    }

    // Link necessary files
    include "classes/dbh.classes.php";
    include "classes/categories.classes.php";
    include "classes/categories-view.classes.php";
    include "classes/posts.classes.php";
    include "classes/posts-view.classes.php";
    
    $categoryInfo = new CategoryView();
    $authorInfo = new PostsView();

    $categoryDetails = $categoryInfo->fetchCategory();
    $authorDetails = $authorInfo->fetchAuthor();

    $pageTitle = 'Posts';

    include "templates/header.php";
?>
<div class="container px-0 py-5 min-vh-100">
    <div class="row border-bottom pb-2 mb-5">
        <div class="col-sm-12 col-md-10 mx-auto">
            <h3>Add New Post</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-10 mx-auto">
            <form action="includes/posts.inc.php" method="post" enctype="multipart/form-data">
                <?php if(isset($postError)): ?> 
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($postError, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-sm-12 col-md-6 mb-3">
                        <select name="postAuthor" id="postAuthor" class="form-select" aria-label="post author select">
                            <option selected>Select an author for this post</option>
                            <?php foreach($authorDetails as $authorDetail) { ?>
                                <option value="<?php echo htmlspecialchars($authorDetail["username"]); ?>">
                                    <?php echo htmlspecialchars($authorDetail["username"]); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6 mb-3">
                        <select name="postCategory" id="postCategory" class="form-select" aria-label="post category select">
                            <option selected>Select a category for this post</option>
                            <?php foreach($categoryDetails as $categoryDetail) { ?>
                                <option value="<?php echo htmlspecialchars($categoryDetail["cat_name"], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($categoryDetail["cat_name"], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="postTitle" id="postTitle" class="form-control" placeholder="Add Title">
                    <label for="postTitle">Add Title</label>
                </div>
                <div class="my-3">
                    <textarea class="form-control" name="postContent" id="postContent" cols="30" rows="10"></textarea>
                </div>
                <div class="my-3">
                    <label for="featuredImage" class="form-label">Upload a featured image</label>
                    <input type="file" name="featuredImage" id="formFile" class="form-control">
                </div>
                <div class="form-check form-switch my-3">
                    <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" role="switch">
                    <label for="is_featured" class="form-check-label">
                        Make this a featured post
                    </label>
                </div>
                <div class="my-3">
                    <button type="submit" class="btn btn-primary" name="submit">Publish Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "templates/footer.php"; ?>