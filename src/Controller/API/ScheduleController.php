<?php

namespace App\Controller\API;

use App\Repository\ScheduleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\ViewModel\Transformer\ScheduleDTOTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/json/schedule')]
class ScheduleController extends AbstractController
{
    public function __construct(
        private ScheduleDTOTransformer $scheduleDTOTransformer,
        private ScheduleRepository $scheduleRepository
    ) {
    }

    #[Route('/', name: 'json_schedule_list', methods: ['GET'], options: ['expose' => true])]
    public function list(): JsonResponse
    {
        $schedules = $this->scheduleRepository->findAllAsc();

        return new JsonResponse([
            'list' => $this->scheduleDTOTransformer->fromSchedules($schedules),
        ]);
    }
}