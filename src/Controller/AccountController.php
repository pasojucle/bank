<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Account;
use App\Form\AccountType;
use App\Repository\AccountRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/account')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'account_index', methods: ['GET'])]
    public function index(AccountRepository $accountRepository): Response
    {
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        return $this->render('account/index.html.twig', [
            'accounts' => $accountRepository->findAllAcs(),
        ]);
    }

    #[Route('/new', name: 'account_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AccountRepository $accountRepository): Response
    {
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $account = new Account();
        /** @var User $user */
        $user = $this->getUser();
        $account->setUser($user);
        $form = $this->createForm(AccountType::class, $account, [
            'action' => $this->generateUrl($request->attributes->get('_route')),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountRepository->save($account, true);

            return $this->redirectToRoute('account_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Créer un compte',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'account_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Account $account, AccountRepository $accountRepository): Response
    {
        $form = $this->createForm(AccountType::class, $account, [
            'action' => $this->generateUrl($request->attributes->get('_route'), ['id' => $account->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountRepository->save($account, true);

            return $this->redirectToRoute('account_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('modal/form.html.twig', [
            'title' => 'Créer un compte',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'account_delete', methods: ['POST'])]
    public function delete(Request $request, Account $account, AccountRepository $accountRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$account->getId(), $request->request->get('_token'))) {
            $accountRepository->remove($account, true);
        }

        return $this->redirectToRoute('account_index', [], Response::HTTP_SEE_OTHER);
    }
}
