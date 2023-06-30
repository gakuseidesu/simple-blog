<?php
    session_start();

    // Check if user is logged in. If not, then redirect to login
    if(!isset($_SESSION["isLoggedInToSimpleBlog"]) && $_SESSION["isLoggedInToSimpleBlog"] != "true") {
        header("Location: login.php");
        exit();
    }

    $pageTitle = 'Dashboard';

    include "templates/header.php";
?>
<div class="container px-0 py-5 min-vh-100">
    <div class="row">
        <div class="col-sm-12 col-md-10 mx-auto">
            <h2><span class="display-1 text-primary">Welcome</span> to your dashboard!</h2>
            <p class="lead">I don't know what will be put on here yet, but something will be put on here... eventually.</p>
        </div>
    </div>
</div>

<?php include "templates/footer.php"; ?>