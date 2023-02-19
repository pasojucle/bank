<?php

declare(strict_types=1);

namespace App\ViewModel\Cluster;

use App\ViewModel\Cluster\ClusterViewModel;

class ClustersViewModel
{
    public ?array $clusters = [];

    public static function fromClusters(array $clusters): ClustersViewModel
    {
        $clustersViewModel = [];

        foreach ($clusters as $cluster) {
            $clustersViewModel[] = ClusterViewModel::fromCluster($cluster);
        }

        $clustersView = new self();
        $clustersView->clusters = $clustersViewModel;

        return $clustersView;
    }
}
