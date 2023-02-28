<?php

declare(strict_types=1);

namespace App\ViewModel\Cluster;

use App\Entity\Cluster;
use App\ViewModel\AbstractPresenter;
use App\ViewModel\Cluster\ClusterViewModel;

class ClusterPresenter extends AbstractPresenter
{
    private $viewModel;

    public function present(?Cluster $cluster): void
    {
        if (null !== $cluster) {
            $this->viewModel = ClusterViewModel::fromCluster($cluster);
        } else {
            $this->viewModel = new ClusterViewModel();
        }
    }

    public function viewModel(): ClusterViewModel
    {
        return $this->viewModel;
    }
}
