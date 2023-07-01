<?php
    session_start();

    // Check if user is logged in. If not, then redirect to login
    if(!isset($_SESSION["isLoggedInToSimpleBlog"]) && $_SESSION["isLoggedInToSimpleBlog"] != "true") {
        header("Location: login.php");
        exit();
    }

    // Link necessary files
    include "classes/dbh.classes.php";
    include "classes/categories.classes.php";
    include "classes/categories-view.classes.php";

    $categoryInfo = new CategoryView();

    $pageTitle = 'Categories';

    include "templates/header.php";
?>
<div class="container px-0 py-5 min-vh-100">
    <div class="row border-bottom pb-4 mb-4">
        <div class="col text-start">
            <h1>Category</h1>
        </div>
    </div>
    <div class="row">
        <?php 
            if(isset($_SESSION['categoryError'])) { 
                echo "<div class='alert alert-danger' role='alert'>" . htmlspecialchars(($_SESSION['categoryError']), ENT_QUOTES, 'UTF-8') . "</div>";

                // Clear session variable
                unset($_SESSION['categoryError']);
            
            }
        ?>
        <div class="col-sm-12">
            <form action="includes/category.inc.php" method="post">
                <div class="row g-2">
                    <div class="col-md form-floating mb-3">
                        <input type="text" name="category" id="category" class="form-control" placeholder="Category title">
                        <label for="category">Category Title</label>
                    </div>
                    <div class="col-md my-auto">
                        <button class="btn btn-primary" type="submit" id="button-addon2">Create category</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-12">
            <form action="includes/deletecategory.inc.php" method="post">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Category Name</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $categoryDetails = $categoryInfo->fetchCategory();
                            if(count($categoryDetails) === 0) {
                        ?>
                                <tr>
                                    <th scope="row">&nbsp;</th>
                                    <td></td>
                                </tr>
                    </tbody>
                </table>
                        <?php } else {
                
                            foreach($categoryDetails as $categoryDetail) {
                        ?>
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input categoryCheckbox" name="checkbox-<?php echo htmlspecialchars($categoryDetail["id"], ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars($categoryDetail["id"], ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                    </th>
                                    <td><?php echo htmlspecialchars($categoryDetail["cat_name"], ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                        <?php
                            }
                        ?>
                            
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target ="#deleteModal">
                    Delete Selected Categories
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
                                    Are you sure you want to delete the selected categories?
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Delete Selected Categories</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            <script>
                document.getElementById('checkAllCat').addEventListener('change', function(){
                    var checkboxes = document.getElementsByClassName('categoryCheckbox');
                    for (var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].checked = this.checked;
                    }
                });
            </script>
        </div>
    </div>
</div>

<?php include "templates/footer.php"; ?>