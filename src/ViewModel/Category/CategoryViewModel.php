<?php

declare(strict_types=1);

namespace App\ViewModel\Category;

use App\Entity\Category;

class CategoryViewModel
{
    public ?int $id = null;
    public string $name = '';
    public string $entityName;

    public static function fromCategory(Category $category)
    {
        $categoryView = new self();
        $categoryView->entityName = get_class($category);
        $categoryView->id = $category->getId();
        $categoryView->name = $category->getName();

        return $categoryView;
    }
}
