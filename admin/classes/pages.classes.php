<?php
class Pages extends Dbh {

    // Method to create page
    protected function setPage($pagesTitle, $pagesContent, $featuredImage, $featuredImage2) {
        $stmt = $this->connect()->prepare('INSERT INTO pages (title, content, featuredImage, featuredImage2) VALUES (?, ?, ?, ?);');
        
        // Bind the values
        $stmt->bindParam(1, $pagesTitle);
        $stmt->bindParam(2, $pagesContent);
        $stmt->bindParam(3, $featuredImage);
        $stmt->bindParam(4, $featuredImage2);

        if (!$stmt->execute()) {
            // Error occurred during execution
            $errorInfo = $stmt->errorInfo();
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Statement failed to insert page into the database. Error: " . $errorInfo[2];
            header("location: ../addpage.php");
            exit(); 
        }

        $stmt = null;
    }

    // Method to update page
    protected function updatePage($pagesTitle, $pagesContent, $featuredImage, $featuredImage2, $pagesId) {
        $stmt = $this->connect()->prepare('UPDATE pages SET title = ?, content = ?, featuredImage = ?, featuredImage2 = ? WHERE id = ?;');

        // Bind the values
        $stmt->bindParam(1, $pagesTitle);
        $stmt->bindParam(2, $pagesContent);
        $stmt->bindParam(3, $featuredImage);
        $stmt->bindParam(4, $featuredImage2);
        $stmt->bindParam(5, $pagesId);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Statement failed to update page in the database. Error: " . $errorInfo[2];
            header("location: ../editpage.php?q=" . $pagesId);
            exit(); 
        }

        $stmt = null;
    }

    // Method to delete page
    protected function removePage($pagesId) {
        $stmt = $this->connect()->prepare('DELETE FROM pages WHERE id = ?;');

        // Bind the value
        $stmt->bindParam(1, $pagesId);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Failed to delete page from the database. Error: " . $errorInfo[2];
            header("location: ../pages.php");
            exit();
        }

    }

    // Method to get page by id
    protected function getPageById($pagesId) {
        $stmt = $this->connect()->prepare('SELECT * FROM pages WHERE id = ?;');

        $stmt->bindParam(1, $pagesId);

        if (!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Statement failed to get page by id.";
            header("location: ../pages.php");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Page not found.";
            header("location: ../pages.php");
            exit();
        }

        $pageById = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $pageById;
    }

    // Method to get pageId by Title
    protected function getPageIdByTitle($pageTitle) {
        $stmt = $this->connect()->prepare('SELECT id FROM pages WHERE title = ?;');
        $stmt->bindParam(1, $pageTitle);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Failed to get page ID by title. Error: " . $errorInfo[2];
            header("location: index.php");
            exit();
        }

        $pageData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $pageData['id'];
    }

    // Method to get all pages
    protected function getAllPages() {
        $stmt = $this->connect()->prepare('SELECT * FROM pages');

        if (!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Statement failed to retrieve all pages.";
            header("location: ../pages.php");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "There are no pages found.";
            header("location: ../pages.php");
            exit();
        }

        $pageData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $pageData;
    }

    // Method for getting the Pages title to edit
    protected function getPagesTitleToEdit($pagesId) {
        $stmt = $this->connect()->prepare('SELECT title FROM pages WHERE id = ?;');
        $stmt->bindParam(1, $pagesId);

        if (!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Statement failed to get the page title.";
            header("location: ../editpage.php?q=" . $pagesId);
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Title not found.";
            header("location: ../editpage.php?q=" . $pagesId);
            exit();
        }

        $pagesDataToEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pagesDataToEdit[0]["title"];
    }

    // Method for getting the Pages content to edit
    protected function getPagesContentToEdit($pagesId) {
        $stmt = $this->connect()->prepare('SELECT content FROM pages WHERE id = ?;');
        $stmt->bindParam(1, $pagesId);

        if (!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Statement failed to get the Pages content.";
            header("location: ../editpage.php?q=" . $pagesId);
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Content not found.";
            header("location: ../editpage.php?q=" . $pagesId);
            exit();
        }

        $pagesDataToEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pagesDataToEdit[0]["content"];
    }

    // Method for getting the page's featured image
    protected function getPagesFeaturedImage($pagesId) {
        $stmt = $this->connect()->prepare('SELECT featuredImage FROM pages WHERE id = ?;');
        $stmt->bindParam(1, $pagesId);

        if (!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Statement failed to get the featured image.";
            header("location: ../editpage.php?q=" . $pagesId);
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "The featured image for this page is empty.";
            header("location: ../editpage.php?q=" . $pagesId);
            exit();
        }

        $pagesDataToEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $pagesDataToEdit[0]["featuredImage"];
    }

    // Method for getting the second featured images for the page
    protected function getPagesFeaturedImage2($pagesId) {
        $stmt = $this->connect()->prepare('SELECT featuredImage2 FROM pages WHERE id = ?');
        $stmt->bindParam(1, $pagesId);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Failed to retrieve featuredImage2. Error: " . $errorInfo[2];
            header("location: ../editpage.php?q=" . $pagesId);
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "The second featured images for this page is empty.";
            header("location: ../editpage.php?q=" . $pagesId);
            exit();
        }

        $pagesDataToEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $pagesDataToEdit[0]["featuredImage2"];
    }

    // Method that checks for duplicate pages
    protected function checkPage($pageTitle, $pageContent) {
        $stmt = $this->connect()->prepare('SELECT title, content FROM pages WHERE title = ? AND content = ?;');
        $stmt->bindParam(1, $pageTitle);
        $stmt->bindParam(2, $pageContent);

        if (!$stmt->execute()) {
            $stmt = null;
            session_start();
            $_SESSION['pagesError'] = "Statement failed to check for duplications.";
            header("location: ../pages.php");
            exit();
        }

        // check results, if any
        $resultCheck;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

}