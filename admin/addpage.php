<?php
    session_start();

    // Check if user is logged in.
    if(!isset($_SESSION["isLoggedInToSimpleBlog"]) && $_SESSION["isLoggedInToSimpleBlog"] != "true") {
        header("Location: login.php");
        exit();
    }

    // Checks for session pagesErrors
    if(isset($_SESSION['pagesError'])) {
        $pagesError = $_SESSION['pagesError'];
        
        //clear the pagesError session variable
        unset($_SESSION['pagesError']);
    }

    $pageTitle = 'Add Page';

    include "templates/header.php";
?>
<div class="container px-0 py-5 min-vh-100">
    <div class="row border-bottom pb-2 mb-5">
        <div class="col-sm-12 col-md-10 mx-auto">
            <h3>Create New Page</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-10 mx-auto">
            <form action="includes/pages.inc.php" method="post" enctype="multipart/form-data">
                <?php if (isset($pagesError)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($pagesError, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
                <div class="form-floating mb-3">
                    <input type="text" name="pagesTitle" id="pagesTitle" class="form-control" placeholder="Add Page Title">
                    <label for="pagesTitle">Add Page Title</label>
                </div>
                <div class="my-3">
                    <textarea name="pagesContent" id="pagesContent" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="my-3">
                    <label for="featuredImage" class="form-label">Upload a featured image</label>
                    <input type="file" name="featuredImage" id="formFile" class="form-control">
                </div>
                <div class="my-3">
                    <label for="featuredImage2" class="form-label">Upload a second featured image</label>
                    <input type="file" name="featuredImage2" id="formFile" class="form-control">
                </div>
                <div class="my-3">
                    <button type="submit" class="btn btn-primary" name="submit">Publish Page</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "templates/footer.php"; ?>