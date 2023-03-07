<?php

declare(strict_types=1);

namespace App\ViewModel\Category;

use App\Entity\Category;
use App\Entity\Enum\CategoryType;
use App\ViewModel\ServicesPresenter;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoryViewModel
{
    public ?int $id = null;
    public string $name = '';
    public string $type = '';

    public string $entityName;

    public static function fromCategory(Category $category, ServicesPresenter $services)
    {
        $categoryView = new self();
        $categoryView->entityName = get_class($category);
        $categoryView->id = $category->getId();
        $categoryView->name = mb_convert_case($category->getName(), MB_CASE_TITLE, 'UTF-8');
        $categoryView->type = $services->translator->trans(sprintf('category_type.%s', $category->getType()->value));

        return $categoryView;
    }
}
