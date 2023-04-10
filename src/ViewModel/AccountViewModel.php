<?php

declare(strict_types=1);

namespace App\ViewModel;


class AccountViewModel
{
    public ?int $id = null;
    public string $name = '';
    public string $entityName;
    public string $actualBalance;
    public string $checkedBalance;
}
