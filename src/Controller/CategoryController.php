<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\ViewModel\Category\CategoryPresenter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/category')]
class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryPresenter $categoryPresenter,
    ) {
    }
    
    #[Route('/', name: 'category_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('category/index.html.twig');
    }

    #[Route('/new', name: 'category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl($request->attributes->get('_route')),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            $this->categoryPresenter->present($category);
            return new JsonResponse($this->categoryPresenter->viewModel());
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Créer un compte',
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/edit', name: 'category_edit', methods: ['GET', 'POST'], options: ['expose' => true])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl($request->attributes->get('_route'), ['id' => $category->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            $this->categoryPresenter->present($category);
            return new JsonResponse($this->categoryPresenter->viewModel());
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Créer un compte',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
        }

        return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
    }
}
