<?php
class PostsView extends Posts {
    public function fetchPost() {
        $postData = $this->getAllPostsInfo();
        
        return $postData;
    }

    public function fetchPostById($postId) {
        $postData = $this->getPostInfoById($postId);

        return $postData;
    }

    public function fetchAuthor() {
        $authorData = $this->getUserInfo();

        return $authorData;
    }

    // fetch post infos separately to edit
    public function fetchPostToEdit($postId) {
        $postData = $this->getPostInfoToEdit($postId);

        return $postData;
    }

    public function fetchPostAuthor($postId) {
        $postAuthorData = $this->getPostAuthorToEdit($postId);

        return $postAuthorData;
    }

    public function fetchPostCategory($postId) {
        $postCategoryData = $this->getPostCategoryToEdit($postId);

        return $postCategoryData;
    }

    public function fetchPostsByCategory($categoryName) {
        $postByCategoryData = $this->getPostsByCategory($categoryName);

        return $postByCategoryData;
    }

    public function fetchPostTitle($postId) {
        $postTitleData = $this->getPostTitleToEdit($postId);

        return $postTitleData;
    }

    public function fetchPostContent($postId) {
        $postContentData = $this->getPostContentToEdit($postId);

        return $postContentData;
    }

    public function fetchPostFeaturedImage($postId) {
        $postFeaturedImageData = $this->getPostFeaturedImage($postId);
        return $postFeaturedImageData;
    }

    public function fetchFeaturedPost() {
        $featuredPostData = $this->getFeaturedPost();
        return $featuredPostData;
    }

    public function fetchRecentPosts() {
        $recentPostData = $this->getRecentPosts();
        return $recentPostData;
    }

    public function isThePostFeatured($postId) {
        $featuredPostData = $this->isPostFeatured($postId);
        return $featuredPostData;
    }

    public function deletePost($postId) {
        return $this->removePost($postId);
    }
}