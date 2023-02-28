<?php

declare(strict_types=1);

namespace App\ViewModel\Category;

use App\ViewModel\ServicesPresenter;
use App\ViewModel\Category\CategoryViewModel;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoriesViewModel
{
    public ?array $categories = [];

    public static function fromCategories(array $categories, ServicesPresenter $services): CategoriesViewModel
    {
        $categoriesViewModel = [];

        foreach ($categories as $category) {
            $categoriesViewModel[] = CategoryViewModel::fromCategory($category, $services);
        }

        $categoriesView = new self();
        $categoriesView->categories = $categoriesViewModel;

        return $categoriesView;
    }
}
