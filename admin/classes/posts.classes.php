<?php
class Posts extends Dbh {

    // Method to add posts
    protected function setPost($postAuthor, $postCategory, $postTitle, $postContent, $featuredImage, $isFeatured) {
        $stmt = $this->connect()->prepare('INSERT INTO posts (author, category, title, content, featuredImage, is_featured) VALUES (?, ?, ?, ?, ?, ?);');

        // Bind the values
        $stmt->bindParam(1, $postAuthor);
        $stmt->bindParam(2, $postCategory);
        $stmt->bindParam(3, $postTitle);
        $stmt->bindParam(4, $postContent);
        $stmt->bindParam(5, $featuredImage);
        $stmt->bindParam(6, $isFeatured);

        if(!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement Failed to insert post into the database.";
            header("location: ../addpost.php");
            exit();
        }

        $stmt = null;
    }

    // Method to update a post
    protected function setNewPostInfo($postAuthor, $postCategory, $postTitle, $postContent, $featuredImage, $isFeatured, $id) {
        $stmt = $this->connect()->prepare('UPDATE posts SET author = ?, category = ?, title = ?, content = ?, featuredImage = ?, is_featured = ? WHERE id = ?');

        $stmt->bindParam(1, $postAuthor);
        $stmt->bindParam(2, $postCategory);
        $stmt->bindParam(3, $postTitle);
        $stmt->bindParam(4, $postContent);
        $stmt->bindParam(5, $featuredImage);
        $stmt->bindParam(6, $isFeatured);
        $stmt->bindParam(7, $id);


        if(!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement failed to update the post.";
            header("location: ../editpost.php");
            exit();
        }

        $stmt = null;
    }

    // Method to check if a post already exist and prevent duplicates
    protected function checkPost($postAuthor, $postCategory, $postTitle) {
        $stmt = $this->connect()->prepare('SELECT author, category, title FROM posts WHERE author = ? AND category = ? AND title = ?;');

        if(!$stmt->execute(array($postAuthor, $postCategory, $postTitle))) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement failed to check for duplications.";
            header("location: ../addpost.php");
            exit();
        }

        // check results, if any
        $resultCheck;
        if($stmt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

    // Method for getting all post info
    protected function getAllPostsInfo() {
        $stmt = $this->connect()->prepare('SELECT * FROM posts');

        // execute sql
        if(!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement failed.";
            header("location: ../posts.php");
            exit();
        }

        // check results
        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['postNotFound'] = "There are no posts found to display.";
            exit();
        }

        $postData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $postData;
    }

    // Method for geting user info for author
    protected function getUserInfo() {
        $stmt = $this->connect()->prepare('SELECT username FROM users');

        // execute sql
        if(!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement failed to get username.";
            exit();
        }

        // check results
        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "There are no users found.";
            exit();
        }

        $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $userData;
    }

    // Method for getting post info to edit
    protected function getPostInfoToEdit($postId) {
        $stmt = $this->connect()->prepare('SELECT * FROM posts WHERE id = ?;');
        $stmt->bindParam(1, $postId);
        
        // execute sql
        if(!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Failed to get post info. Error: " . $errorInfo[2];
            header("location: ../posts.php");
            exit();
        }

        // check results
        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['postNotFound'] = "There are no posts found to display.";
            exit();
        }

        $postDataToEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $postDataToEdit;
    }

    // Method to get post by Id
    protected function getPostInfoById($postId) {
        $stmt = $this->connect()->prepare('SELECT * FROM posts WHERE id = ?;');
        $stmt->bindParam(1, $postId);

        // execute sql
        if(!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement failed.";
            header("location: ../posts.php");
            exit();
        }

        // check results
        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['postNotFound'] = "There are no posts found to display.";
            exit();
        }

        $postDataToEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $postDataToEdit;
    }

    // Method for getting post Author to edit
    protected function getPostAuthorToEdit($postId) {
        $stmt = $this->connect()->prepare('SELECT author FROM posts WHERE id = ?;');

        // execute sql
        if(!$stmt->execute(array($postId))) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement failed.";
            header("location: ../editposts.php");
            exit();
        }

        // check results
        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['postNotFound'] = "There are no posts found to display.";
            exit();
        }

        $postDataToEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $postDataToEdit[0]["author"];
    }

    // Method for getting post Category to edit
    protected function getPostCategoryToEdit($postId) {
        $stmt = $this->connect()->prepare('SELECT category FROM posts WHERE id = ?;');

        // execute sql
        if(!$stmt->execute(array($postId))) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement failed.";
            header("location: ../editposts.php");
            exit();
        }

        // check results
        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['postNotFound'] = "There are no posts found to display.";
            exit();
        }

        $postDataToEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $postDataToEdit[0]["category"];
    }

    // Method for getting post Title to edit
    protected function getPostTitleToEdit($postId) {
        $stmt = $this->connect()->prepare('SELECT title FROM posts WHERE id = ?;');

        // execute sql
        if(!$stmt->execute(array($postId))) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement failed.";
            header("location: ../editposts.php");
            exit();
        }

        // check results
        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['postNotFound'] = "There are no posts found to display.";
            exit();
        }

        $postDataToEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $postDataToEdit[0]["title"];
    }

    // Method for getting post Title to edit
    protected function getPostContentToEdit($postId) {
        $stmt = $this->connect()->prepare('SELECT content FROM posts WHERE id = ?;');

        // execute sql
        if(!$stmt->execute(array($postId))) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement failed.";
            header("location: ../editposts.php");
            exit();
        }

        // check results
        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['postNotFound'] = "There are no posts found to display.";
            header("location: editpost.php");
            exit();
        }

        $postDataToEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $postDataToEdit[0]["content"];
    }

    // Method for getting the post's featured image
    protected function getPostFeaturedImage($postId) {
        $stmt = $this->connect()->prepare('SELECT featuredImage FROM posts WHERE id = ?;');
        $stmt->bindParam(1, $postId);

        // execute
        if(!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement for getting the featured image failed.";
            header("location: ../editpost.php");
            exit();
        }

        // check results
        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "The featured image for this post is empty.";
            header("location: ../editpost.php");
            exit();
        }

        $postDataToEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $postDataToEdit[0]["featuredImage"];
    }

    // Method for getting the featured post
    protected function getFeaturedPost() {
        $stmt = $this->connect()->prepare('SELECT * FROM posts WHERE is_featured = 1;');
        
        // execute
        if(!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Statement for getting the is_featured failed. Error: " . $errorInfo[2];
            header("location: ../editpost.php?q=" . $postId);
            exit();
        }

        // check results
        if($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "There are no featured post.";
            header("location: index.php");
            exit();
        }

        $featuredPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $featuredPosts;
    }

    // Method to get all posts by category
    public function getPostsByCategory($categoryName) {
        $stmt = $this->connect()->prepare('SELECT * FROM posts WHERE category = ?');
        $stmt->bindParam(1, $categoryName);

        // execute
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Failed to retrieve posts by category. Error: " . $errorInfo[2];
            header("location: ../posts.php");
            exit();
        }

        $postsByCategory = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $postsByCategory;
    }

    public function getRecentPosts() {
        $stmt = $this->connect()->prepare('SELECT * FROM posts ORDER BY created_at DESC LIMIT 2;');

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Failed to retrieve the recents posts. Error: " . $errorInfo[2];
            header("location: ../posts.php");
            exit();
        }

        $recentPostsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $recentPostsData;
    }

    // Method for check if the post is featured
    protected function isPostFeatured($postId) {
        $stmt = $this->connect()->prepare('SELECT is_featured FROM posts WHERE id = ?;');
        $stmt->bindParam(1, $postId);
        
        // execute
        if(!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "is_featured value check failed. Error: " . $errorInfo[2];
            header("location: ../editpost.php?q=" . $postId);
            exit();
        }

        $result = $stmt->fetchColumn();

        return $result;
    }

    // Method for removing a post from db
    protected function removePost($pagesId) {
        $stmt = $this->connect()->prepare('DELETE FROM posts WHERE id = ?;');
        $stmt->bindParam(1, $pagesId);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $stmt = null;
            session_start();
            $_SESSION['postError'] = "Failed to delete posts. Error: " . $errorInfo[2];
            header("location: ../posts.php");
            exit();
        }
    }

}