<?php

declare(strict_types=1);

namespace App\ViewModel\Transformer;

use App\Entity\Account;
use App\Entity\Transaction;
use App\ViewModel\ImportViewModel;
use App\Service\TransactionService;

class ImportDTOTransformer
{
    public function __construct(
        private AccountDTOTransformer $accountDTOtransformer,
        private LabelDTOTransformer $labelDTOTransformer,
        private TransactionService $transactionService
    )
    {
        
    }

    public function fromTransaction(Transaction $transaction, Account $account, int $id): ImportViewModel
    {
        $importView = new ImportViewModel;

        $importView->entityName = 'import';
        $importView->id = $id;
        $importView->createdAt = $transaction->getCreatedAt()->format('d/m/Y');
        $importView->label = $this->labelDTOTransformer->fromLabel($transaction->getLabel());
        $importView->debitAccount = ($transaction->getDebitAccount()) ? $this->accountDTOtransformer->fromAccount($transaction->getDebitAccount()) : null;
        $importView->creditAccount = ($transaction->getCreditAccount()) ?  $this->accountDTOtransformer->fromAccount($transaction->getCreditAccount()) : null;
        $importView->amount = $this->transactionService->getAmount($transaction, $account);
        $importView->transactionId = $transaction->getId();


        return $importView;
    }
}
