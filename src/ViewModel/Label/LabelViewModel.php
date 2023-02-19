<?php

declare(strict_types=1);

namespace App\ViewModel\Label;

use App\Entity\Label;

class LabelViewModel
{
    public ?int $id = null;
    public string $name = '';
    public string $entityName;

    public static function fromLabel(Label $label)
    {
        $labelView = new self();

        $labelView->entityName = get_class($label);
        $labelView->id = $label->getId();
        $labelView->name = $label->getName();

        return $labelView;
    }
}
