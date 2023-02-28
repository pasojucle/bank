<?php

declare(strict_types=1);

namespace App\ViewModel\Transaction;

use App\ViewModel\ServicesPresenter;
use App\ViewModel\Transaction\TransactionViewModel;

class TransactionsViewModel
{
    public ?array $transactions = [];

    public static function fromTransactions(array $transactions, ServicesPresenter $services): TransactionsViewModel
    {
        $transactionsViewModel = [];

        foreach ($transactions as $transaction) {
            $transactionsViewModel[] = TransactionViewModel::fromTransaction($transaction, $services);
        }

        $transactionsView = new self();
        $transactionsView->transactions = $transactionsViewModel;

        return $transactionsView;
    }
}
