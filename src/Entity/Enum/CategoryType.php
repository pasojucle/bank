<?php

declare(strict_types=1);

namespace App\Entity\Enum;

enum CategoryType: string 
{
    case REVENUE = 'revenue'; 
    case EXPENSE = 'expense'; 
    case SAVING = 'saving';

     /**
     * @return array<string,string>
     */
    public static function getAsArray(): array
    {
        return array_reduce(
            self::cases(),
            static fn (array $choices, CategoryType $type) => $choices + [$type->name => $type->value],
            [],
        );
    }
}