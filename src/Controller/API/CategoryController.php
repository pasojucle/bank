<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Entity\Label;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\ViewModel\Transformer\CategoryDTOTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/json/category')]
class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryDTOTransformer $categoryDTOTransformer,
        private CategoryRepository $categoryRepository
    ) {
    }

    #[Route('/', name: 'json_category_list', methods: ['GET'], options: ['expose' => true])]
    public function list(): JsonResponse
    {
        return new JsonResponse([
            'list' => $this->categoryDTOTransformer->fromCategories($this->categoryRepository->findAllASC()),
        ]);
    }

    #[Route('/{id}', name: 'api_category_show', methods: ['GET'])]
    public function show(Category $category): JsonResponse
    {
        return new JsonResponse([
            'category' => $this->categoryDTOTransformer->fromCategory($category),
        ]);
    }

    #[Route('/{id}/edit', name: 'api_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
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



    #[Route('/default/{label}', name: 'json_category_default', methods: ['GET'], options: ['expose' => true])]
    public function defaultCategory(
        Label $label
    ): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        return new JsonResponse([
            'category' => $this->categoryDTOTransformer->fromCategory($this->categoryRepository->findDefaultByLabel($label, $user)),
        ]);
    }
}
