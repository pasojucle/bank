<?php

namespace App\Controller;

use App\Entity\Label;
use App\Form\LabelType;
use App\Repository\LabelRepository;
use App\ViewModel\Label\LabelPresenter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/label')]
class LabelController extends AbstractController
{
    public function __construct(private LabelPresenter $labelPresenter) {
        
    }
    
    #[Route('/', name: 'label_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('label/index.html.twig');
    }

    #[Route('/new', name: 'label_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LabelRepository $labelRepository): Response
    {
        $label = new Label();
        $form = $this->createForm(LabelType::class, $label, [
            'action' => $this->generateUrl($request->attributes->get('_route')),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $labelRepository->save($label, true);

            $this->labelPresenter->present($label);
            return new JsonResponse($this->labelPresenter->viewModel());
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Créer un Libellé',
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/edit', name: 'label_edit', methods: ['GET', 'POST'], options: ['expose' => true])]
    public function edit(Request $request, Label $label, LabelRepository $labelRepository): Response
    {
        $form = $this->createForm(LabelType::class, $label, [
            'action' => $this->generateUrl($request->attributes->get('_route'), ['id' => $label->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $labelRepository->save($label, true);

            $this->labelPresenter->present($label);
            return new JsonResponse($this->labelPresenter->viewModel());
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Modifier un libellé',
            'form' => $form->createView(),
        ]);
    }
}