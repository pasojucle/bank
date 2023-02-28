<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Repository\AccountRepository;
use App\ViewModel\Account\AccountsPresenter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        /** @var User $user */
        $user = $this->getUser();
        $this->accountsPresenter->present($this->accountRepository->findByUser($user));
        return new JsonResponse([
            'list' => $this->accountsPresenter->viewModel()->accounts,
        ]);
    }
}