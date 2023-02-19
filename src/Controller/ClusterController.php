<?php

namespace App\Controller;

use App\Entity\Cluster;
use App\Form\ClusterType;
use App\Repository\ClusterRepository;
use App\ViewModel\Cluster\ClusterPresenter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cluster')]
class ClusterController extends AbstractController
{
    public function __construct(private ClusterPresenter $clusterPresenter) {
        
    }
    
    #[Route('/', name: 'cluster_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('cluster/index.html.twig');
    }

    #[Route('/new', name: 'cluster_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClusterRepository $clusterRepository): Response
    {
        $cluster = new Cluster();
        $form = $this->createForm(ClusterType::class, $cluster, [
            'action' => $this->generateUrl($request->attributes->get('_route')),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clusterRepository->save($cluster, true);

            $this->clusterPresenter->present($cluster);
            return new JsonResponse($this->clusterPresenter->viewModel());
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Créer un groupe',
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/edit', name: 'cluster_edit', methods: ['GET', 'POST'], options: ['expose' => true])]
    public function edit(Request $request, Cluster $cluster, ClusterRepository $clusterRepository): Response
    {
        $form = $this->createForm(ClusterType::class, $cluster, [
            'action' => $this->generateUrl($request->attributes->get('_route'), ['id' => $cluster->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clusterRepository->save($cluster, true);

            $this->clusterPresenter->present($cluster);
            return new JsonResponse($this->clusterPresenter->viewModel());
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Modifier un groupe',
            'form' => $form->createView(),
        ]);
    }
}