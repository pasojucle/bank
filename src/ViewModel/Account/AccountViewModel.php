<?php

declare(strict_types=1);

namespace App\ViewModel\Account;

use App\Entity\Account;
use App\Model\Currency;
use App\ViewModel\ServicesPresenter;

class AccountViewModel
{
    public ?int $id = null;
    public string $name = '';
    public string $entityName;
    public string $actualBalance;
    public string $checkedBalance;

    public static function fromAccount(Account $account, ServicesPresenter $services)
    {
        $accountView = new self();

        $accountView->entityName = get_class($account);
        $accountView->id = $account->getId();
        $accountView->name =  $account->getName();
        $accountView->actualBalance = $accountView->getActualBalance($account, $services);
        $accountView->checkedBalance = $accountView->getCheckedBalance($account, $services);

        return $accountView;
    }

    private function getActualBalance(Account $account, ServicesPresenter $services): string
    {
        $balance = $services->transactionRepository->getActualBalanceByAccount($account);

        return (new Currency($balance))->toString();
    }

    private function getCheckedBalance(Account $account, ServicesPresenter $services): string
    {
        $balance = $services->transactionRepository->getCheckedBalanceByAccount($account);

        return (new Currency($balance))->toString();
    }
}
