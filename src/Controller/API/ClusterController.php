<?php

namespace App\Controller\API;

use App\Repository\ClusterRepository;
use App\ViewModel\Cluster\ClustersPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/cluster')]
class ClusterController extends AbstractController
{
    public function __construct(
        private ClustersPresenter $clustersPresenter,
        private ClusterRepository $clusterRepository
    ) {
    }

    #[Route('/', name: 'api_cluster_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $this->clustersPresenter->present($this->clusterRepository->findAllASC());
        return new JsonResponse([
            'clusters' => $this->clustersPresenter->viewModel()->clusters,
        ]);
    }
}