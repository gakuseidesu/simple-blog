<?php
class CategoryView extends Category {

    public function fetchCategory() {
        $categoryData = $this->getCategoryInfo();

        return $categoryData;
    }

    public function fetchCategoryId() {
        $categoryData = $this->getCategoryId();

        return $categoryData[0]["id"];
    }

    public function fetchCategoryNameById($categoryId) {
        $categoryData = $this->getCategoryNameById($categoryId);

        return $categoryData[0]["cat_name"];
    }

    public function deleteCategory($categoryId) {
        return $this->removeCategory($categoryId);
    }

}