<?php

declare(strict_types=1);

namespace App\ViewModel;

class CategoryViewModel
{
    public ?int $id = null;
    public string $name = '';
    public string $type = '';

    public string $entityName;
}
