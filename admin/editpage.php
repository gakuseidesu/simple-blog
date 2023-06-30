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

    // Link necessary files
    include "classes/dbh.classes.php";
    include "classes/pages.classes.php";
    include "classes/pages-view.classes.php";

    $pagesInfoToEdit = new PagesView();

    // get the page id
    $pagesId = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_NUMBER_INT);

    $pageTitle = 'Edit Page';

    include "templates/header.php";
?>
<div class="container px-0 py-5 min-vh-100">
    <div class="row border-bottom pb-2 mb-5">
        <div class="col-sm-12 col-md-10 mx-auto">
            <h3>Edit Page</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-10 mx-auto">
            <form action="includes/editpage.inc.php" method="post" enctype="multipart/form-data">
                <?php if (isset($pagesError)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($pagesError, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
                <div class="form-floating mb-3">
                    <input type="text" name="pagesTitle" id="pagesTitle" class="form-control" placeholder="Edit Page Title" value="<?php echo htmlspecialchars($pagesInfoToEdit->fetchPagesTitle($pagesId), ENT_QUOTES, 'UTF-8'); ?>">
                    <label for="pagesTitle">Edit Page Title</label>
                </div>
                <div class="my-3">
                    <?php
                        $retrievedContent = $pagesInfoToEdit->fetchPagesContent($pagesId);
                        $content = htmlspecialchars_decode($retrievedContent);
                        echo "<textarea class='form-control' name='pagesContent' id='pagesContent' cols='30' rows='10'>" . $content . "</textarea>";
                    ?>
                </div>
                <div class="my-3">
                    <?php
                        $currentFeaturedImage = $pagesInfoToEdit->fetchPagesFeaturedImage($pagesId);
                        echo "Current featured image: " . htmlspecialchars($currentFeaturedImage, ENT_QUOTES, 'UTF-8') . "</br>";
                    ?>
                    <label for="featuredImage" class="form-label">Edit this featured image</label>
                    <input type="file" name="featuredImage" id="formFile" class="form-control">
                </div>
                <div class="my-3">
                    <?php
                        $secondFeaturedImage = $pagesInfoToEdit->fetchPagesFeaturedImage2($pagesId);
                        echo "Current second featured image: " . htmlspecialchars($secondFeaturedImage, ENT_QUOTES, 'UTF-8') . "</br>";
                    ?>
                    <label for="featuredImage2" class="form-label">Edit the second featured image</label>
                    <input type="file" name="featuredImage2" id="formFile" class="form-control">
                </div>
                <div class="my-3">
                    <input type="hidden" name="pagesId" value="<?php echo htmlspecialchars($pagesId, ENT_QUOTES, 'UTF-8'); ?>">
                    <button type="submit" class="btn btn-primary" name="submit">Edit Page</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "templates/footer.php"; ?>