<?php

declare(strict_types=1);

namespace App\ViewModel\Category;

use App\Entity\Category;
use App\ViewModel\AbstractPresenter;
use App\ViewModel\Category\CategoryViewModel;

class CategoryPresenter extends AbstractPresenter
{
    private $viewModel;


    public function present(?Category $category): void
    {
        if (null !== $category) {
            $this->viewModel = CategoryViewModel::fromCategory($category, $this->services);
        } else {
            $this->viewModel = new CategoryViewModel();
        }
    }

    public function viewModel(): CategoryViewModel
    {
        return $this->viewModel;
    }
}
