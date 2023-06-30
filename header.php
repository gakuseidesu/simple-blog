<?php
    // linked files
    require_once "./admin/classes/dbh.classes.php";
    require_once "./admin/classes/pages.classes.php";
    require_once "./admin/classes/pages-view.classes.php";
    require_once "./admin/classes/categories.classes.php";
    require_once "./admin/classes/categories-view.classes.php";

    $pagesDetails = new PagesView();
    $categoryDetails = new CategoryView();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#sb-contactForm',
            height: 500,
            menubar: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
    <title>Simple Blog</title>
</head>
<body>
    <section id="navigation">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light" aria-label="Offcanvas navbar large">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <h1>Simple Blog</h1>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Navigation</h5>
                            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                                </li>
                                <?php
                                    $pages = $pagesDetails->fetchPages();
                                    foreach ($pages as $page) {
                                        $pageTitle = $page["title"];
                                        $pageId = $pagesDetails->fetchPagesIdByTitle($pageTitle);
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="page.php?q=<?php echo htmlspecialchars($pageId, ENT_QUOTES, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </li>
                                <?php
                                    }
                                ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Categories
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php
                                            $categories = $categoryDetails->fetchCategory();
                                            foreach ($categories as $category) {
                                                $categoryId = $category["id"];
                                                $categoryName = $category["cat_name"];
                                        ?>
                                            <li>
                                                <a href="category.php?q=<?php echo htmlspecialchars($categoryId, ENT_QUOTES, 'UTF-8'); ?>" class="dropdown-item">
                                                    <?php echo htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8'); ?>
                                                </a>
                                            </li>
                                        <?php
                                            }
                                        ?>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="contact.php" class="nav-link">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </section>