<?php

namespace App\Controller;

use App\Entity\Deadline;
use App\Form\DeadlineType;
use App\Repository\DeadlineRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\ViewModel\Transformer\DeadlineDTOTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/deadline')]
class DeadlineController extends AbstractController
{
    public function __construct(
        private DeadlineDTOTransformer $deadlineDTOTransformer,
    ) {
    }
    
    #[Route('/', name: 'deadline_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('deadline/index.html.twig');
    }

    #[Route('/new', name: 'deadline_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DeadlineRepository $deadlineRepository): Response
    {
        $deadline = new Deadline();
        $form = $this->createForm(DeadlineType::class, $deadline, [
            'action' => $this->generateUrl($request->attributes->get('_route')),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deadlineRepository->save($deadline, true);

            return new JsonResponse([
                [
                    'entity' => 'deadline',
                    'value' => $this->deadlineDTOTransformer->fromDeadline($deadline),
                    'sort' => 'nameASC',
                ]
            ]);
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Créer une échéance',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'deadline_edit', methods: ['GET', 'POST'], options: ['expose' => true])]
    public function edit(Request $request, Deadline $deadline, DeadlineRepository $deadlineRepository): Response
    {
        $form = $this->createForm(DeadlineType::class, $deadline, [
            'action' => $this->generateUrl($request->attributes->get('_route'), ['id' => $deadline->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deadlineRepository->save($deadline, true);

            return new JsonResponse([
                [
                    'entity' => 'deadline',
                    'value' => $this->deadlineDTOTransformer->fromDeadline($deadline),
                    'sort' => 'nameASC',
                ]
            ]);
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Modifier une catégorie',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'deadline_delete', methods: ['POST'])]
    public function delete(Request $request, Deadline $deadline, DeadlineRepository $deadlineRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $deadline->getId(), $request->request->get('_token'))) {
            $deadlineRepository->remove($deadline, true);
        }

        return $this->redirectToRoute('deadline_index', [], Response::HTTP_SEE_OTHER);
    }
}
