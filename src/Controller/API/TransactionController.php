<?php

namespace App\Controller\API;

use App\Entity\Account;
use App\Repository\TransactionRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\ViewModel\Transformer\TransactionDTOTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/json/transaction')]
class TransactionController extends AbstractController
{
    public function __construct(
        private TransactionDTOTransformer $transactionDTOTransformer,
        private TransactionRepository $transactionRepository
    ) {
    }

    #[Route('/{account}', name: 'json_transaction_list', methods: ['GET'], options: ['expose' => true])]
    public function list(Account $account): JsonResponse
    {
        $transactions = $this->transactionRepository->findByAccount($account);

        return new JsonResponse([
            'list' => $this->transactionDTOTransformer->fromTransactions($transactions, $account),
        ]);
    }
}