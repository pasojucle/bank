<?php

declare(strict_types=1);

namespace App\ViewModel\Cluster;

use App\ViewModel\AbstractPresenter;

class ClustersPresenter extends AbstractPresenter
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
