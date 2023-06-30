<?php
class PostsContr extends Posts {
    private $postAuthor;
    private $postCategory;
    private $postTitle;
    private $postContent;
    private $featuredImage;

    public function __construct($postAuthor, $postCategory, $postTitle, $postContent) {
        $this->postAuthor = $postAuthor;
        $this->postCategory = $postCategory;
        $this->postTitle = $postTitle;
        $this->postContent = $postContent;
        $this->featuredImage = '';
    }

    // Method to set the featured image
    public function setFeaturedImage($sanitizedFileName){
        $this->featuredImage = $sanitizedFileName;
    }

    // Method to publish a post
    public function createPost($isFeatured) {
        // Error handler
        if($this->emptyInput() == false) {
            session_start();
            $_SESSION['postError'] = "Please fill in all of the fields.";
            header("location: ../addpost.php");
            exit();
        }

        if($this->postTakenCheck() == false) {
            session_start();
            $_SESSION['postError'] = "Post duplicate found.";
            header("location: ../addpost.php");
            exit();
        }

        $this->setFeaturedImage($this->featuredImage);
        $this->setPost($this->postAuthor, $this->postCategory, $this->postTitle, $this->postContent, $this->featuredImage, $isFeatured);
    }

    // update a post
    public function editPost($isFeatured, $postId) {
        if (!empty($this->featuredImage)) {
            $this->setFeaturedImage($this->featuredImage);
        } else {
            $this->featuredImage = $this->getPostFeaturedImage($postId);
            $this->setFeaturedImage($this->featuredImage);
        }

        $this->setNewPostInfo($this->postAuthor, $this->postCategory, $this->postTitle, $this->postContent, $this->featuredImage, $isFeatured, $postId);
    }

    // Error Handler
    private function emptyInput() {
        $result;
        if(empty($this->postAuthor) || empty($this->postCategory) || empty($this->postTitle) || empty($this->postContent)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function postTakenCheck() {
        $result;
        if(!$this->checkPost($this->postAuthor, $this->postCategory, $this->postTitle)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }
}