<?php

declare(strict_types=1);

namespace App\ViewModel\Cluster;

class ClustersPresenter
{
    private $viewModel;

    public function present(array $clusters): void
    {
        if (!empty($clusters)) {
            $this->viewModel = ClustersViewModel::fromClusters($clusters);
        } else {
            $this->viewModel = new ClustersViewModel();
        }
    }

    public function viewModel(): ClustersViewModel
    {
        return $this->viewModel;
    }
}
