<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Form\ScheduleType;
use App\Repository\ScheduleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\ViewModel\Transformer\ScheduleDTOTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/schedule')]
class ScheduleController extends AbstractController
{
    public function __construct(
        private ScheduleDTOTransformer $scheduleDTOTransformer,
    ) {
    }
    
    #[Route('/', name: 'schedule_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('schedule/index.html.twig');
    }

    #[Route('/new', name: 'schedule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ScheduleRepository $scheduleRepository): Response
    {
        $schedule = new Schedule();
        $form = $this->createForm(ScheduleType::class, $schedule, [
            'action' => $this->generateUrl($request->attributes->get('_route')),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scheduleRepository->save($schedule, true);

            return new JsonResponse([
                [
                    'entity' => 'schedule',
                    'value' => $this->scheduleDTOTransformer->fromSchedule($schedule),
                    'sort' => 'nameASC',
                ]
            ]);
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Créer une échéance',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'schedule_edit', methods: ['GET', 'POST'], options: ['expose' => true])]
    public function edit(Request $request, Schedule $schedule, ScheduleRepository $scheduleRepository): Response
    {
        $form = $this->createForm(ScheduleType::class, $schedule, [
            'action' => $this->generateUrl($request->attributes->get('_route'), ['id' => $schedule->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scheduleRepository->save($schedule, true);

            return new JsonResponse([
                [
                    'entity' => 'schedule',
                    'value' => $this->scheduleDTOTransformer->fromSchedule($schedule),
                    'sort' => 'nameASC',
                ]
            ]);
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Modifier une catégorie',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'schedule_delete', methods: ['POST'])]
    public function delete(Request $request, Schedule $schedule, ScheduleRepository $scheduleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $schedule->getId(), $request->request->get('_token'))) {
            $scheduleRepository->remove($schedule, true);
        }

        return $this->redirectToRoute('schedule_index', [], Response::HTTP_SEE_OTHER);
    }
}
