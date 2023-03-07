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
        $accountView->name =  mb_convert_case($account->getName(), MB_CASE_TITLE, 'UTF-8');

        return $accountView;
    }
}
