<?php

namespace App\Controller\API;

use App\Repository\AccountRepository;
use App\ViewModel\Account\AccountsPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/account')]
class AccountController extends AbstractController
{
    public function __construct(
        private AccountsPresenter $accountsPresenter,
        private AccountRepository $accountRepository
    ) {
    }

    #[Route('/', name: 'api_account_list', methods: ['GET'], options: ['expose' => true])]
    public function list(): JsonResponse
    {
        $this->accountsPresenter->present($this->accountRepository->findAllASC());
        return new JsonResponse([
            'accounts' => $this->accountsPresenter->viewModel()->accounts,
        ]);
    }
}