<?php

declare(strict_types=1);

namespace App\ViewModel;


use App\ViewModel\AccountViewModel;

class ImportViewModel
{
    public string $entityName;
    public ?int $id = null;
    public ?string $createdAt = null;
    public LabelViewModel $label;
    public ?AccountViewModel $debitAccount;
    public ?AccountViewModel $creditAccount;
    public string $amount;
    public ?int $transactionId = null;
}
