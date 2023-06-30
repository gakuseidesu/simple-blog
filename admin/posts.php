<?php
    session_start();

    // Check if user is logged in. If not, then redirect to login
    if(!isset($_SESSION["isLoggedInToSimpleBlog"]) && $_SESSION["isLoggedInToSimpleBlog"] != "true") {
        header("Location: login.php");
        exit();
    }

    // Link necessary files
    include "classes/dbh.classes.php";
    include "classes/posts.classes.php";
    include "classes/posts-view.classes.php";

    $postInfo = new PostsView();

    $pageTitle = 'Posts';

    include "templates/header.php";
?>
<div class="container px-0 py-5 min-vh-100">
    <div class="row border-bottom pb-2 mb-5">
        <div class="d-flex flex-row justify-content-between">
            <div class="col text-start">
                <h3>Posts</h3>
            </div>
            <div class="col text-end">
                <a href="addpost.php" class="btn btn-primary" role="button">Add Post</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
                if (isset($_SESSION['postError'])) {
                    echo "<div class='alert alert-danger' role='alert'>" . htmlspecialchars(($_SESSION['postError']), ENT_QUOTES, 'UTF-8') . "</div>";
                }
            ?>
            <form action="includes/deletepost.inc.php" method="post">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Categories</th>
                            <th scope="col">Date Published</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $postDetails = $postInfo->fetchPost();

                            if (count($postDetails) === 0) {
                        ?>
                            <tr>
                                <th scope="row">&nbsp;</th>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                        <?php
                            } else {

                            foreach ($postDetails as $postDetail) { 
                                $postId = $postDetail["id"];
                        ?>
                        <tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input postCheckbox" name="checkbox-<?php echo htmlspecialchars($postId, ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars($postId, ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </th>
                            <td>
                                <a href="editpost.php?q=<?php echo htmlspecialchars($postId, ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($postDetail["title"], ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($postDetail["author"], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($postDetail["category"], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($postDetail["created_at"], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    Delete Selected Post
                </button> 
                <?php } ?>
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLabel">Alert!</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger" role="alert">
                                    Are you sure you want to delete the selected posts?
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Delete Selected Post</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "templates/footer.php"; ?>