<?php
    include "./admin/classes/dbh.classes.php";
    include "./admin/classes/categories.classes.php";
    include "./admin/classes/categories-view.classes.php";
    include "./admin/classes/posts.classes.php";
    include "./admin/classes/posts-view.classes.php";
    include "header.php";

    $categoryDetails = new CategoryView();
    $postDetails = new PostsView();


    $categoryId = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_NUMBER_INT);

    $categoryName = $categoryDetails->fetchCategoryNameById($categoryId);

?>
    <section id="main" class="min-vh-100 py-5">
        <div class="container px-0">
            <div class="row g-2 mb-2">
                <?php
                    $postsByCategory = $postDetails->fetchPostsByCategory($categoryName);

                    foreach ($postsByCategory as $post) {
                        $postId = $post["id"];
                        $postTitle = $post["title"];
                        $postContent = $post["content"];
                        $postFeaturedImage = $post["featuredImage"];
                        $postCategory = $post["category"];
                        $publishDate = date("F j, Y", strtotime($post["created_at"]));

                        // Split the content into sentences
                        $sentences = preg_split('/(?<=[.?!])\s+/', $postContent);
                        $excerpt = implode(' ', array_slice($sentences, 0, 2));

                ?>
                        <div class="col-md-6 equal-height-col">
                            <div class="row g-0 border rounded-0 overflow-hidden d-flex flex-md-row mb-4 shadow-sm position-relative align-items-stretch">
                                <div class="col p-4 d-flex flex-column position-static">
                                    <strong class="d-inline-block mb-2 text-success-emphasis">
                                        <?php echo htmlspecialchars($postCategory, ENT_QUOTES, 'UTF-8'); ?>
                                    </strong>
                                    <h3 class="mb-0">
                                        <?php echo htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8'); ?>
                                    </h3>
                                    <div class="mb-1 text-body-secondary">
                                        <?php echo htmlspecialchars($publishDate, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                    <p class="mb-auto">
                                        <?php echo $excerpt; ?>
                                    </p>
                                    <a href="posts.php?q=<?php echo htmlspecialchars($postId, ENT_QUOTES, 'UTF-8'); ?>" class="icon-link gap-1 icon-link-hover stretched-link">
                                        Continue reading
                                    </a>
                                </div>
                                <div class="col-auto d-none d-lg-block">
                                    <div class="cat-hero d-flex justify-content-center align-items-center" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('./admin/img/<?php echo htmlspecialchars($postFeaturedImage, ENT_QUOTES, 'UTF-8'); ?>');">
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </section>
<?php
    include "footer.php";
?>