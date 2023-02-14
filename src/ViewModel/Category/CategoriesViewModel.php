<?php

declare(strict_types=1);

namespace App\ViewModel\Category;

use App\ViewModel\Category\CategoryViewModel;

class CategoriesViewModel
{
    public ?array $categories = [];

    public static function fromCategories(array $categories): CategoriesViewModel
    {
        $categoriesViewModel = [];

        foreach ($categories as $category) {
            $categoriesViewModel[] = CategoryViewModel::fromCategory($category);
        }

        $categoriesView = new self();
        $categoriesView->categories = $categoriesViewModel;

        return $categoriesView;
    }
}
