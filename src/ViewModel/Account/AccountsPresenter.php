<?php

declare(strict_types=1);

namespace App\ViewModel\Account;

use App\Repository\TransactionRepository;
use App\ViewModel\AbstractPresenter;

class AccountsPresenter extends AbstractPresenter
{
    private $viewModel;

    public function present(array $accounts): void
    {
        if (!empty($accounts)) {
            $this->viewModel = AccountsViewModel::fromAccounts($accounts, $this->services);
        } else {
            $this->viewModel = new AccountsViewModel();
        }
    }

    public function viewModel(): AccountsViewModel
    {
        return $this->viewModel;
    }
}
