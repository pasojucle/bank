<?php

declare(strict_types=1);

namespace App\ViewModel\Cluster;

use App\Entity\Cluster;

class ClusterViewModel
{
    public ?int $id = null;
    public string $name = '';
    public string $entityName;

    public static function fromCluster(Cluster $cluster)
    {
        $clusterView = new self();

        $clusterView->entityName = get_class($cluster);
        $clusterView->id = $cluster->getId();
        $clusterView->name = $cluster->getName();

        return $clusterView;
    }
}
