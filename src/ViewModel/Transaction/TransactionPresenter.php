<?php

declare(strict_types=1);

namespace App\ViewModel\Transaction;

use App\Entity\Transaction;
use App\ViewModel\AbstractPresenter;
use App\ViewModel\Transaction\TransactionViewModel;

class TransactionPresenter extends AbstractPresenter
{
    private $viewModel;

    public function present(?Transaction $transaction): void
    {
        if (null !== $transaction) {
            $this->viewModel = TransactionViewModel::fromTransaction($transaction, $this->services);
        } else {
            $this->viewModel = new TransactionViewModel();
        }
    }

    public function viewModel(): TransactionViewModel
    {
        return $this->viewModel;
    }
}
