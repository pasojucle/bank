<?php

declare(strict_types=1);

namespace App\ViewModel\Account;

use App\ViewModel\Account\AccountViewModel;

class AccountsViewModel
{
    public ?array $accounts = [];

    public static function fromAccounts(array $accounts): AccountsViewModel
    {
        $accountsViewModel = [];

        foreach ($accounts as $account) {
            $accountsViewModel[] = AccountViewModel::fromAccount($account);
        }

        $accountsView = new self();
        $accountsView->accounts = $accountsViewModel;

        return $accountsView;
    }
}
