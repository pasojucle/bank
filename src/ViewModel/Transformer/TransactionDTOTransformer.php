<?php

declare(strict_types=1);

namespace App\ViewModel\Transformer;

use App\Entity\Account;
use App\Entity\Transaction;
use App\Service\TransactionService;
use App\ViewModel\TransactionViewModel;

class TransactionDTOTransformer
{
    public function __construct(
        private AccountDTOTransformer $accountDTOtransformer,
        private LabelDTOTransformer $labelDTOTransformer,
        private CategoryDTOTransformer $categoryDTOTransformer,
        private TransactionService $transactionService
    )
    {
        
    }

    public function fromTransaction(Transaction $transaction, Account $account): TransactionViewModel
    {
        $transactionView = new TransactionViewModel;

        $transactionView->entityName = get_class($transaction);
        $transactionView->id = $transaction->getId();
        $transactionView->createdAt = $transaction->getCreatedAt()->format('Y-m-d');
        $transactionView->createdAtStr = $transaction->getCreatedAt()->format('d/m');
        $transactionView->label = $this->labelDTOTransformer->fromLabel($transaction->getLabel());
        $transactionView->category = $this->categoryDTOTransformer->fromCategory($transaction->getCategory());
        $transactionView->debitAccount = ($transaction->getDebitAccount()) ? $this->accountDTOtransformer->fromAccount($transaction->getDebitAccount()) : null;
        $transactionView->creditAccount = ($transaction->getCreditAccount()) ?  $this->accountDTOtransformer->fromAccount($transaction->getCreditAccount()) : null;
        $transactionView->amount = $this->transactionService->getAmount($transaction, $account);
        $transactionView->checked = $transaction->isChecked();
        $transactionView->checkedToStr = ($transaction->isChecked()) ? 'bi bi-check-circle-fill' : 'bi bi-check-circle';
        $transactionView->comment = $transaction->getComment();

        return $transactionView;
    }

    public function fromTransactions(array $transactions, Account $account): array
    {
        $transactionsView = [];

        foreach($transactions as $transaction) {
            $transactionsView[] = $this->fromTransaction($transaction, $account);
        }

        return $transactionsView;
    }
}
