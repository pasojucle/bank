<?php

declare(strict_types=1);

namespace App\Doctrine\DBAL\Type;

use App\Entity\Enum\CategoryType;


class CategoryTypeEnumType extends EnumType
{
    protected function getEnum(): string 
    { 
        return CategoryType::class;
    }

    public function getName() 
    { 
        return 'category_type_enum';
    }
}