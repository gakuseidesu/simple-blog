<?php
    
    include "./admin/classes/dbh.classes.php";
    include "./admin/classes/pages.classes.php";
    include "./admin/classes/pages-view.classes.php";

    $pageDetails = new PagesView();

    $pagesId = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_NUMBER_INT);

    $pagesTitle = $pageDetails->fetchPagesTitle($pagesId);

    include "header.php";
?>
    <section id="main" class="min-vh-100 py-5">
        <div class="container px-0">
        <?php
            $pagesContent = $pageDetails->fetchPagesContent($pagesId);
            $content = htmlspecialchars_decode($pagesContent);
            echo $content;
        ?>
        </div>
    </section>
<?php
    include "footer.php";
?>