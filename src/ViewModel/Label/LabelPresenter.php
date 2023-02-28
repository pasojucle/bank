<?php

declare(strict_types=1);

namespace App\ViewModel\Label;

use App\Entity\Label;
use App\ViewModel\AbstractPresenter;
use App\ViewModel\Label\LabelViewModel;

class LabelPresenter extends AbstractPresenter
{
    private $viewModel;

    public function present(?Label $label): void
    {
        if (null !== $label) {
            $this->viewModel = LabelViewModel::fromLabel($label);
        } else {
            $this->viewModel = new LabelViewModel();
        }
    }

    public function viewModel(): LabelViewModel
    {
        return $this->viewModel;
    }
}
