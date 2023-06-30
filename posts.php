<?php
    
    include "./admin/classes/dbh.classes.php";
    include "./admin/classes/posts.classes.php";
    include "./admin/classes/posts-view.classes.php";

    $postDetails = new PostsView();

    $postId = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_NUMBER_INT);

    include "header.php";
?>
    <section id="main" class="min-vh-100 py-5">
        <div class="container px-0">
        <?php
            $postInfo = $postDetails->fetchPostById($postId);

            foreach ($postInfo as $post) {
                $postTitle = $post["title"];
                $postAuthor = $post["author"];
                $postCategory = $post["category"];
                $postContent = $post["content"];
                $postFeaturedImage = $post["featuredImage"];
        ?>
                <div class="p-5 mb-4 rounded-0 text-body-emphasis postHero d-flex justify-content-center" style="background-image: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.6)), url('./admin/img/<?php echo $postFeaturedImage; ?>');">
                    &nbsp;
                </div>
                <div class="row border-bottom pb-4 mb-4">
                    <h1 class="display-4 fst-italic text-center">
                        <?php echo htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8'); ?>
                    </h1>
                    <p class="lead text-center">
                        by <?php echo htmlspecialchars($postAuthor, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                </div>
                <div class="row border-bottom pb-4 mb-4">
                    <?php echo htmlspecialchars_decode($postContent); ?>
                </div>
                
        <?php } ?>
        </div>
    </section>
<?php
    include "footer.php";
?>