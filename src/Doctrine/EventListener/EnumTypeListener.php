<?php

declare(strict_types=1);

namespace App\Doctrine\EventListener;

use App\Doctrine\DBAL\Type\EnumType;


class EnumTypeListener 
{
    public function postGenerateSchema(\Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs $eventArgs)
    {
        $columns = [];

        foreach ($eventArgs->getSchema()->getTables() as $table) {
            foreach ($table->getColumns() as $column) {
                if ($column->getType() instanceof EnumType) {
                    $columns[] = $column;
                }
            }
        }

        /** @var \Doctrine\DBAL\Schema\Column $column */
        foreach ($columns as $column) {
            /** @var EnumType $type */
            $type = $column->getType();
            $enum = $type->getEnum();

            $cases = array_map(
                fn ($enumItem) => "'{$enumItem->value}'", 
                $enum::cases()
            );

            $hash = md5(implode(',', $cases));

            $column->setComment(trim(sprintf(
                '%s (DC2Enum:%s)', 
                $column->getComment(), 
                $hash 
            )));
        }
    }
}