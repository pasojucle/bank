<?php

declare(strict_types=1);

namespace App\ViewModel\Account;

use App\Repository\TransactionRepository;
use App\ViewModel\Account\AccountViewModel;
use App\ViewModel\ServicesPresenter;

class AccountsViewModel
{
    public ?array $accounts = [];

    public static function fromAccounts(array $accounts, ServicesPresenter $services): AccountsViewModel
    {
        $accountsViewModel = [];

        foreach ($accounts as $account) {
            $accountsViewModel[] = AccountViewModel::fromAccount($account, $services);
        }

        $accountsView = new self();
        $accountsView->accounts = $accountsViewModel;

        return $accountsView;
    }
}
