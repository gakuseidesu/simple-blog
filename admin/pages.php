<?php
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION["isLoggedInToSimpleBlog"]) && $_SESSION["isLoggedInToSimpleBlog"] != "true") {
        header("location: login.php");
        exit();
    }

    // link files
    include "classes/dbh.classes.php";
    include "classes/pages.classes.php";
    include "classes/pages-view.classes.php";

    $pagesInfo = new PagesView();

    $pageTitle = 'Pages';

    include "templates/header.php";
?>
<div class="container px-0 py-5 min-vh-100">
    <div class="row border-bottom pb-2 mb-5">
        <div class="d-flex flex-row justify-content-between">
            <div class="col text-start">
                <h3>Pages</h3>
            </div>
            <div class="col text-end">
                <a href="addpage.php" class="btn btn-primary" role="button">Add Page</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
                if (isset($_SESSION['pagesError'])) {
                    echo "<div class='alert alert-danger' role='alert'>" . htmlspecialchars(($_SESSION['pagesError']), ENT_QUOTES, 'UTF-8') . "</div>";

                    // clear session variable
                    unset($_SESSION['pagesError']);
                }
            ?>
            <form action="includes/deletepage.inc.php" method="post">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Title</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                            $pageDetails = $pagesInfo->fetchPages();

                            if (count($pageDetails) === 0) {
                        ?>
                                <tr>
                                    <th scope="row">&nbsp;</th>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                    </tbody>
                </table>
                        <?php
                            } else {
                        
                                foreach ($pageDetails as $pageDetail) { 
                                    $pagesId = htmlspecialchars($pageDetail["id"]);
                        ?>
                        <tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input pagesCheckbox" name="checkbox-<?php echo htmlspecialchars($pagesId, ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars($pagesId, ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </th>
                            <td>
                                <a href="editpage.php?q=<?php echo htmlspecialchars($pagesId, ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($pageDetail["title"]); ?>
                                </a>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    Delete Selected Pages
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
                                    Are you sure you want to delete the selected pages?
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
        </div>
    </div>
</div>
<?php include "templates/footer.php"; ?>