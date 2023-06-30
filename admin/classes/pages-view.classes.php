<?php
class PagesView extends Pages {
    public function fetchPages() {
        $pagesData = $this->getAllPages();

        return $pagesData;
    }

    public function fetchPagesIdByTitle($pageTitle) {
        $pagesData = $this->getPageIdByTitle($pageTitle);

        return $pagesData;
    }

    public function fetchPageById($pagesId) {
        $pagesByIdData = $this->getPagesById($pagesId);

        return $pagesByIdData;
    }

    public function fetchPagesTitle($pagesId) {
        $pagesData = $this->getPagesTitleToEdit($pagesId);

        return $pagesData;
    }

    public function fetchPagesContent($pagesId) {
        $pagesData = $this->getPagesContentToEdit($pagesId);

        return $pagesData;
    }

    public function fetchPagesFeaturedImage($pagesId) {
        $pagesFeaturedImage = $this->getPagesFeaturedImage($pagesId);

        return $pagesFeaturedImage;
    }

    public function fetchPagesFeaturedImage2($pagesId) {
        $pagesFeaturedImage2 = $this->getPagesFeaturedImage2($pagesId);

        return $pagesFeaturedImage2;
    }

    // Method to delete a page
    public function deletePage($pagesId) {
        return $this->removePage($pagesId);
    }
}