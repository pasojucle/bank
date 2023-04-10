<?php

namespace App\Controller\API;

use App\Entity\Account;
use App\Repository\TransactionRepository;
use App\ViewModel\Transaction\TransactionsPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/json/transaction')]
class TransactionController extends AbstractController
{
    public function __construct(
        private TransactionsPresenter $transactionsPresenter,
        private TransactionRepository $transactionRepository
    ) {
    }

    #[Route('/{account}', name: 'json_transaction_list', methods: ['GET'], options: ['expose' => true])]
    public function list(Account $account): JsonResponse
    {
        $transactions = $this->transactionRepository->findByAccount($account);
        $this->transactionsPresenter->present($transactions);

        return new JsonResponse([
            'list' => $this->transactionsPresenter->viewModel()->transactions,
        ]);
    }
}