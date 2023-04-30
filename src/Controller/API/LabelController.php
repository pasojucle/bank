<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Repository\LabelRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\ViewModel\Transformer\LabelDTOTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        /** @var User $user */
        $user = $this->getUser();

        return new JsonResponse([
            'list' => $this->labelDTOTransformer->fromLabels($this->labelRepository->findByUser($user)),
        ]);
    }
}