<?php

declare(strict_types=1);

namespace App\ViewModel;


use App\ViewModel\AccountViewModel;

class TransactionViewModel
{
    public string $entityName;
    public ?int $id = null;
    public ?string $createdAt = null;
    public ?string $createdAtStr = null;
    public LabelViewModel $label;
    public CategoryViewModel $category;
    public ?AccountViewModel $debitAccount;
    public ?AccountViewModel $creditAccount;
    public string $amount;
    public bool $checked;
    public string $checkedToStr;
    public ?string $comment;
}
