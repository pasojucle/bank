<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Entity\Account;
use App\Repository\AccountRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\ViewModel\Transformer\AccountDTOtransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/json/account')]
class AccountController extends AbstractController
{
    public function __construct(
        private AccountDTOtransformer $accountDTOtransformer,
        private AccountRepository $accountRepository
    ) {
    }

    #[Route('/', name: 'json_account_list', methods: ['GET'], options: ['expose' => true])]
    public function list(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        
        return new JsonResponse([
            'list' => $this->accountDTOtransformer->fromAccounts($this->accountRepository->findByUser($user)),
        ]);
    }

    #[Route('/{id}/etid', name: 'json_account_edit', methods: ['GET'], options: ['expose' => true])]
    public function edit(Account $account): JsonResponse
    {
        return new JsonResponse([
            'entity' => 'account',
            'value' => $this->accountDTOtransformer->fromAccount($account),
            'sort' => 'nameASC',
        ]);
    }
   
}