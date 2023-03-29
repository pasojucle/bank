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
    public ?string $createdAt = null;
    public LabelViewModel $label;
    public CategoryViewModel $category;
    public ?AccountViewModel $debitAccount;
    public ?AccountViewModel $creditAccount;
    public string $amount;
    public bool $checked;
    public ?string $comment;

    public static function fromTransaction(Transaction $transaction, ServicesPresenter $services)
    {
        $transactionView = new self();

        $transactionView->entityName = get_class($transaction);
        $transactionView->id = $transaction->getId();
        $transactionView->createdAt = $transaction->getCreatedAt()->format('Y-m-d');
        $transactionView->label = LabelViewModel::fromLabel($transaction->getLabel());
        $transactionView->category = CategoryViewModel::fromCategory($transaction->getCategory(), $services);
        $transactionView->debitAccount = ($transaction->getDebitAccount()) ? AccountViewModel::fromAccount($transaction->getDebitAccount(), $services) : null;
        $transactionView->creditAccount = ($transaction->getCreditAccount()) ?  AccountViewModel::fromAccount($transaction->getCreditAccount(), $services) : null;
        $transactionView->amount = (new Currency($transaction->getAmount()))->toString();
        $transactionView->checked = $transaction->isChecked();
        $transactionView->comment = $transaction->getComment();
        dump($transaction);

        return $transactionView;
    }
}
