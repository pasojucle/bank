<?php

namespace App\Controller\API;

use App\Repository\DeadlineRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\ViewModel\Transformer\DeadlineDTOTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/json/deadline')]
class DeadlineController extends AbstractController
{
    public function __construct(
        private DeadlineDTOTransformer $deadlineDTOTransformer,
        private DeadlineRepository $deadlineRepository
    ) {
    }

    #[Route('/', name: 'json_deadline_list', methods: ['GET'], options: ['expose' => true])]
    public function list(): JsonResponse
    {
        $deadlines = $this->deadlineRepository->findAllAsc();

        return new JsonResponse([
            'list' => $this->deadlineDTOTransformer->fromDeadlines($deadlines),
        ]);
    }
}