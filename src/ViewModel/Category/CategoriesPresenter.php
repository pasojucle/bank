<?php

declare(strict_types=1);

namespace App\ViewModel\Category;

use App\ViewModel\AbstractPresenter;
use Symfony\Contracts\Translation\TranslatorInterface;


class CategoriesPresenter extends AbstractPresenter
{
    private $viewModel;
    
    public function present(array $categories): void
    {
        if (!empty($categories)) {
            $this->viewModel = CategoriesViewModel::fromCategories($categories, $this->services);
        } else {
            $this->viewModel = new CategoriesViewModel();
        }
    }

    public function viewModel(): CategoriesViewModel
    {
        return $this->viewModel;
    }
}
