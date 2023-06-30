<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#postContent, #pagesContent',
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
    <title>Simple Blog | <?php echo $pageTitle; ?></title>
</head>
<body>
<nav class="navbar navbar-dark bg-dark" aria-label="Dark offcanvas navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php" target="blank">Simple Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarDark" aria-controls="offcanvasNavbarDark" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbarDark" aria-labelledby="offcanvasNavbarDarkLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarDarkLabel">Welcome, <?php echo $_SESSION["simpleBlog_userName"]; ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Categories</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pages
                        </a>
                        <ul class="dropdown-menu bg-dark">
                            <li><a class="dropdown-item text-bg-dark" href="pages.php">View All Pages</a></li>
                            <li><a class="dropdown-item text-bg-dark" href="addpage.php">Create Page</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Posts
                        </a>
                        <ul class="dropdown-menu bg-dark">
                            <li><a class="dropdown-item text-bg-dark" href="posts.php">View All Posts</a></li>
                            <li><a class="dropdown-item text-bg-dark" href="addpost.php">Create Post</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="includes/logout.inc.php" class="nav-link">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>