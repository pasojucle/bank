<?php

declare(strict_types=1);

namespace App\ViewModel\Account;

use App\Entity\Account;

class AccountViewModel
{
    public ?int $id = null;
    public string $name = '';
    public string $entityName;

    public static function fromAccount(Account $account)
    {
        $accountView = new self();

        $accountView->entityName = get_class($account);
        $accountView->id = $account->getId();
        $accountView->name = $account->getName();

        return $accountView;
    }
}
