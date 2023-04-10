<?php

namespace App\Controller\API;

use App\Repository\LabelRepository;
use App\ViewModel\Label\LabelsPresenter;
use App\ViewModel\Transformer\LabelDTOTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/json/label')]
class LabelController extends AbstractController
{
    public function __construct(
        private LabelDTOTransformer $labelDTOTransformer,
        private LabelRepository $labelRepository
    ) {
    }

    #[Route('/', name: 'json_label_list', methods: ['GET'], options: ['expose' => true])]
    public function list(): JsonResponse
    {
        return new JsonResponse([
            'list' => $this->labelDTOTransformer->fromLabels($this->labelRepository->findAllASC()),
        ]);
    }
}