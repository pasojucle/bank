<?php

namespace App\Controller\API;

use App\Repository\TransactionRepository;
use App\ViewModel\Transaction\TransactionsPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/transaction')]
class TransactionController extends AbstractController
{
    public function __construct(
        private TransactionsPresenter $transactionsPresenter,
        private TransactionRepository $transactionRepository
    ) {
    }

    #[Route('/', name: 'api_transaction_list', methods: ['GET'], options: ['expose' => true])]
    public function list(): JsonResponse
    {
        $this->transactionsPresenter->present($this->transactionRepository->findAllASC());
        return new JsonResponse([
            'list' => $this->transactionsPresenter->viewModel()->transactions,
        ]);
    }
}