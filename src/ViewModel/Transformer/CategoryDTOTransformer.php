<?php

declare(strict_types=1);

namespace App\ViewModel\Transformer;

use App\Entity\Category;
use App\ViewModel\CategoryViewModel;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoryDTOTransformer
{
    public function __construct(private TranslatorInterface $translator)
    {
        
    }
    
    public function fromCategory(Category $category): CategoryViewModel
    {
        $categoryView = new CategoryViewModel;
        $categoryView->entityName = get_class($category);
        $categoryView->id = $category->getId();
        $categoryView->name = mb_convert_case($category->getName(), MB_CASE_TITLE, 'UTF-8');
        $categoryView->type = $this->translator->trans(sprintf('category_type.%s', $category->getType()->value));

        return $categoryView;
    }



    public function fromCategories(array $categories): array
    {
        $accountsView = [];

        foreach($categories as $category) {
            $accountsView[] = $this->fromCategory($category);
        }

        return $accountsView;
    }
}
