<?php

namespace App\Controller\API;

use App\Repository\LabelRepository;
use App\ViewModel\Label\LabelsPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/label')]
class LabelController extends AbstractController
{
    public function __construct(
        private LabelsPresenter $labelsPresenter,
        private LabelRepository $labelRepository
    ) {
    }

    #[Route('/', name: 'api_label_list', methods: ['GET'], options: ['expose' => true])]
    public function list(): JsonResponse
    {
        $this->labelsPresenter->present($this->labelRepository->findAllASC());
        return new JsonResponse([
            'list' => $this->labelsPresenter->viewModel()->labels,
        ]);
    }
}