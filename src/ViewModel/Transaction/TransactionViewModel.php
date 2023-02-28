<?php

declare(strict_types=1);

namespace App\ViewModel\Transaction;

use App\Model\Currency;
use App\Entity\Transaction;
use App\ViewModel\Label\LabelViewModel;
use App\ViewModel\Account\AccountViewModel;
use App\ViewModel\Category\CategoryViewModel;
use App\ViewModel\ServicesPresenter;

class TransactionViewModel
{

    public string $entityName;
    public ?int $id = null;
    public LabelViewModel $label;
    public CategoryViewModel $category;
    public AccountViewModel $debitAccount;
    public AccountViewModel $creditAccount;
    public string $amount;
    public bool $checked;
    public string $comment;

    public static function fromTransaction(Transaction $transaction, ServicesPresenter $services)
    {
        $transactionView = new self();

        $transactionView->entityName = get_class($transaction);
        $transactionView->id = $transaction->getId();
        $transactionView->label = LabelViewModel::fromLabel($transaction->getLabel());
        $transactionView->category = CategoryViewModel::fromCategory($transaction->getCategory(), $services);
        $transactionView->debitAccount = AccountViewModel::fromAccount($transaction->getDebitAccount());
        $transactionView->creditAccount = AccountViewModel::fromAccount($transaction->getCreditAccount());
        $transactionView->amount = (new Currency($transaction->getAmount()))->toString();
        $transactionView->checked = $transaction->isChecked();
        $transactionView->comment = $transaction->getComment();

        return $transactionView;
    }
}
