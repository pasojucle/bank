<?php

declare(strict_types=1);

namespace App\ViewModel\Category;

use App\Entity\BikeRide;
use App\Entity\Category;
use App\ViewModel\Category\CategoryViewModel;

class CategoryPresenter
{
    private $viewModel;

    public function present(?Category $category): void
    {
        if (null !== $category) {
            $this->viewModel = CategoryViewModel::fromCategory($category);
        } else {
            $this->viewModel = new CategoryViewModel();
        }
    }

    public function viewModel(): CategoryViewModel
    {
        return $this->viewModel;
    }
}
