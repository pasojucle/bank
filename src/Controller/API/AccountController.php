<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Entity\Account;
use App\Repository\AccountRepository;
use App\ViewModel\Account\AccountPresenter;
use App\ViewModel\Account\AccountsPresenter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/account')]
class AccountController extends AbstractController
{
    public function __construct(
        private AccountPresenter $accountPresenter,
        private AccountsPresenter $accountsPresenter,
        private AccountRepository $accountRepository
    ) {
    }

    #[Route('/', name: 'api_account_list', methods: ['GET'], options: ['expose' => true])]
    public function list(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $this->accountsPresenter->present($this->accountRepository->findByUser($user));
        return new JsonResponse([
            'list' => $this->accountsPresenter->viewModel()->accounts,
        ]);
    }

    #[Route('/{id}/etid', name: 'api_account_edit', methods: ['GET'], options: ['expose' => true])]
    public function edit(Account $account): JsonResponse
    {
        $this->accountPresenter->present($account);
        return new JsonResponse([
            'entity' => 'account',
            'value' => $this->accountPresenter->viewModel(),
            'sort' => 'nameASC',
        ]);
    }
   
}