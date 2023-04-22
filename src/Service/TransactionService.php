<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AbstractTransaction;
use App\Entity\Account;
use App\Model\Currency;


class TransactionService
{
    public function getAmount(AbstractTransaction $transaction, ?Account $account): string
    {
        $symbol = ($account === $transaction->getDebitAccount()) ? '- ' : '';
        return $symbol . (new Currency($transaction->getAmount()))->toString();
    }
}
