<?php

declare(strict_types=1);

namespace App\ViewModel\Label;

class LabelsPresenter
{
    private $viewModel;

    public function present(array $labels): void
    {
        if (!empty($labels)) {
            $this->viewModel = LabelsViewModel::fromLabels($labels);
        } else {
            $this->viewModel = new LabelsViewModel();
        }
    }

    public function viewModel(): LabelsViewModel
    {
        return $this->viewModel;
    }
}
