<?php

declare(strict_types=1);

namespace App\ViewModel;


use App\ViewModel\AccountViewModel;

class DeadlineViewModel
{
    public string $entityName;
    public ?int $id = null;
    public LabelViewModel $label;
    public CategoryViewModel $category;
    public ?AccountViewModel $debitAccount;
    public ?AccountViewModel $creditAccount;
    public string $amount;
}
