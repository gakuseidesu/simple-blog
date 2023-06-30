<?php
class PagesContr extends Pages {
    private $pagesTitle;
    private $pagesContent;
    private $featuredImage;
    private $featuredImage2;

    public function __construct($pagesTitle, $pagesContent) {
        $this->pagesTitle = $pagesTitle;
        $this->pagesContent = $pagesContent;
        $this->featuredImage = '';
        $this->featuredImage2 = '';
    }

    public function setFeaturedImage($sanitizedFileName) {
        $this->featuredImage = $sanitizedFileName;
    }

    public function setFeaturedImage2($sanitizedFileName) {
        $this->featuredImage2 = $sanitizedFileName;
    }

    // Method to publish a page
    public function createPage() {
        // Error handler
        if ($this->emptyInput() == false) {
            session_start();
            $_SESSION['pagesError'] = "Please fill in the fields.";
            header("location: ../addpage.php");
            exit();
        }

        // check for duplicates
        if ($this->pagesTakenCheck() == false) {
            session_start();
            $_SESSION['pagesError'] = "Pages duplicate found.";
            header("location: ../addpage.php");
            exit();
        }

        $this->setFeaturedImage($this->featuredImage);
        $this->setFeaturedImage2($this->featuredImage2);
        $this->setPage($this->pagesTitle, $this->pagesContent, $this->featuredImage, $this->featuredImage2);
    }

    // Method to update a page
    public function editPage($pagesId) {
        if (!empty($this->featuredImage)) {
            $this->setFeaturedImage($this->featuredImage);
        } else {
            $this->featuredImage = $this->getPagesFeaturedImage($pagesId);
            $this->setFeaturedImage($this->featuredImage);
        }

        if (!empty($this->featuredImage2)) {
            $this->setFeaturedImage2($this->featuredImage2);
        } else {
            $this->featuredImage2 = $this->getPagesFeaturedImage2($pagesId);
            $this->setFeaturedImage2($this->featuredImage2);
        }

        $this->updatePage($this->pagesTitle, $this->pagesContent, $this->featuredImage, $this->featuredImage2, $pagesId);
    }

    // Error handlers
    private function emptyInput() {
        $result;
        if(empty($this->pagesTitle) || empty($this->pagesContent)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function pagesTakenCheck() {
        $result;
        if(!$this->checkPage($this->pagesTitle, $this->pagesContent)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }
}