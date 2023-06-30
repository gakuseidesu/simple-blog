<?php 
    // Linked files
    include "./admin/classes/dbh.classes.php";
    include "./admin/classes/posts.classes.php";
    include "./admin/classes/posts-view.classes.php";

    $postsDetails = new PostsView();
    
    include "header.php"; 
?>
    <section id="main" class="min-vh-100 py-5">
        <div class="container px-0">
            <?php
                $featuredPosts = $postsDetails->fetchFeaturedPost();

                // Check if any featured posts exist
                if (!empty($featuredPosts)) {
                    // Pick a random featured post
                    $randomIndex = array_rand($featuredPosts);
                    $featuredPost = $featuredPosts[$randomIndex];

                    $featuredPostId = $featuredPost["id"];
                    $featuredPostTitle = $featuredPost["title"];
                    $featuredPostContent = $featuredPost["content"];
                    $featuredPostFeaturedImage = $featuredPost["featuredImage"];

                    // Split the content into sentences
                    $sentences = preg_split('/(?<=[.?!])\s+/', $featuredPostContent);
                    $featuredExcerpt = implode(' ', array_slice($sentences, 0, 2));

                }
            ?>
            <div class="mb-4 rounded-0 text-body-emphasis bg-body-secondary sb-hero d-flex justify-content-end" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.9)), url('./admin/img/<?php echo $featuredPostFeaturedImage; ?>');">
                <div class="col-lg-6 text-light p-5 d-flex flex-column justify-content-stretch" style="background-color: rgba(0, 0, 0, 0.7);">
                    <h1 class="display-4 fst-italic">
                        <?php echo htmlspecialchars($featuredPostTitle, ENT_QUOTES, 'UTF-8'); ?>
                    </h1>
                    <p class="lead my-3">
                        <?php echo htmlspecialchars_decode($featuredExcerpt); ?>
                    </p>
                    <p class="lead mb-0 text-light">
                        <a href="posts.php?q=<?php echo htmlspecialchars($featuredPostId, ENT_QUOTES, 'UTF-8'); ?>" class="fw-bold text-light">
                            Continue reading...
                        </a>
                    </p>
                </div>
            </div>
            <div class="row g-4 mb-2">
                <?php
                    $recentPosts = $postsDetails->fetchRecentPosts();

                    foreach ($recentPosts as $recentPost) {
                        $recentPostId = $recentPost["id"];
                        $recentPostTitle = $recentPost["title"];
                        $recentPostContent = $recentPost["content"];
                        $recentPostFeaturedImage = $recentPost["featuredImage"];
                        $recentPostCategory = $recentPost["category"];
                        $recentPostPublishDate = date("F j, Y", strtotime($recentPost["created_at"]));

                        // Split the content into sentences
                        $recentPostSentences = preg_split('/(?<=[.?!])\s+/', $recentPostContent);
                        $recentPostExcerpt = implode(' ', array_slice($recentPostSentences, 0, 1));
                    
                ?>
                <div class="col-md-6 equal-height-col">
                    <div class="row g-0 border rounded-0 overflow-hidden d-flex flex-md-row mb-4 shadow-sm position-relative align-items-stretch">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-primary-emphasis">
                                <?php 
                                    echo htmlspecialchars($recentPostCategory, ENT_QUOTES, 'UTF-8');
                                ?>
                            </strong>
                            <h3 class="mb-0">
                                <?php echo htmlspecialchars($recentPostTitle, ENT_QUOTES, 'UTF-8'); ?>
                            </h3>
                            <div class="mb-1 text-body-secondary">
                                <?php echo htmlspecialchars($recentPostPublishDate, ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <p class="card-text mb-auto">
                                <?php echo htmlspecialchars_decode($recentPostExcerpt); ?>
                            </p>
                            <a href="posts.php?q=<?php echo htmlspecialchars($recentPostId, ENT_QUOTES, 'UTF-8'); ?>" class="icon-link gap-1 icon-link-hover stretched-link">
                                Continue reading
                            </a>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <div class="rp-hero d-flex justify-content-center align-items-center" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('./admin/img/<?php echo htmlspecialchars($recentPostFeaturedImage, ENT_QUOTES, 'UTF-8'); ?>');">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="row mb-2 pb-2">
                <div class="col">
                    <h3 class="pb-1 mb-2 fst-italic border-bottom">
                        &nbsp;
                    </h3>
                    <?php
                        $posts = $postsDetails->fetchPost();

                        $count = 0;

                        foreach ($posts as $post) {
                            // Display only the first 5 posts
                            if ($count >= 5) {
                                break;
                            }

                            $postId = $post["id"];
                            $postTitle = $post["title"];
                            $publishDate = date("F j, Y", strtotime($post["created_at"]));
                            $postAuthor = $post["author"];
                            $postContent = $post["content"];

                            // Split the content into sentences
                            $sentences = preg_split('/(?<=[.?!])\s+/', $postContent);
                            $excerpt = implode(' ', array_slice($sentences, 0, 3));

                            // Add "read more" link
                            $readMoreLink = '<a href="posts.php?q=' . $postId . '">Read more...</a>';
                            $excerptWithLink = $excerpt . ' ' . $readMoreLink;
                    ?>
                        <article class="blog-post border-bottom mb-3">
                            <h2 class="display-5 link-body-emphasis mb-1">
                                <a class="text-dark text-decoration-none" href="posts.php?q=<?php echo htmlspecialchars($postId, ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h2>
                            <p class="blog-post-meta">
                                <?php echo $publishDate; ?> by 
                                <?php echo htmlspecialchars($postAuthor, ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                            <p><?php echo htmlspecialchars_decode($excerptWithLink); ?></p>
                        </article>
                    <?php
                            $count++; // Increment the counter variable
                        }
                    ?>
                    
                    <!-- <nav class="blog-pagination mb-3" aria-label="Pagination">
                        <a class="btn btn-outline-primary rounded-pill" href="#">Older</a>
                        <a class="btn btn-outline-secondary rounded-pill disabled">Newer</a>
                    </nav> -->
                </div>
            </div>
        </div>
    </section>
<?php include "footer.php" ?>