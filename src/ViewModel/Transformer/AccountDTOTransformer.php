<?php

declare(strict_types=1);

namespace App\ViewModel\Transformer;

use App\Entity\Account;
use App\Model\Currency;
use App\Repository\TransactionRepository;
use App\ViewModel\AccountViewModel;

class AccountDTOTransformer
{
    public function __construct(private TransactionRepository $transactionRepository)
    {
        
    }

    public function fromAccount(Account $account): AccountViewModel
    {
        $accountView = new AccountViewModel;

        $accountView->entityName = get_class($account);
        $accountView->id = $account->getId();
        $accountView->name =  $account->getName();
        $accountView->actualBalance = $this->getActualBalance($account);
        $accountView->checkedBalance = $this->getCheckedBalance($account);

        return $accountView;
    }

    public function fromAccounts(array $accounts): array
    {
        $accountsView = [];

        foreach($accounts as $account) {
            $accountsView[] = $this->fromAccount($account);
        }

        return $accountsView;
    }

    private function getActualBalance(Account $account): string
    {
        $balance = $this->transactionRepository->getActualBalanceByAccount($account);

        return (new Currency($balance))->toString();
    }

    private function getCheckedBalance(Account $account): string
    {
        $balance = $this->transactionRepository->getCheckedBalanceByAccount($account);

        return (new Currency($balance))->toString();
    }
}
