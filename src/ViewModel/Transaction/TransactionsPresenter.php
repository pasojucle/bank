<?php

declare(strict_types=1);

namespace App\ViewModel\Transaction;

use App\ViewModel\AbstractPresenter;

class TransactionsPresenter extends AbstractPresenter
{
    private $viewModel;

    public function present(array $transactions): void
    {
        if (!empty($transactions)) {
            $this->viewModel = TransactionsViewModel::fromTransactions($transactions, $this->services);
        } else {
            $this->viewModel = new TransactionsViewModel();
        }
    }

    public function viewModel(): TransactionsViewModel
    {
        return $this->viewModel;
    }
}
