<?php

declare(strict_types=1);

namespace App\ViewModel\Category;


class CategoriesPresenter
{
    private $viewModel;

    public function present(array $categories): void
    {
        if (!empty($categories)) {
            $this->viewModel = CategoriesViewModel::fromCategories($categories);
        } else {
            $this->viewModel = new CategoriesViewModel();
        }
    }

    public function viewModel(): CategoriesViewModel
    {
        return $this->viewModel;
    }
}
