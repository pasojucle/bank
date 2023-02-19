<?php

declare(strict_types=1);

namespace App\ViewModel\Account;

class AccountsPresenter
{
    private $viewModel;

    public function present(array $accounts): void
    {
        if (!empty($accounts)) {
            $this->viewModel = AccountsViewModel::fromAccounts($accounts);
        } else {
            $this->viewModel = new AccountsViewModel();
        }
    }

    public function viewModel(): AccountsViewModel
    {
        return $this->viewModel;
    }
}
