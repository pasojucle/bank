<?php

declare(strict_types=1);

namespace App\ViewModel\Transformer;

use App\Entity\Label;
use App\ViewModel\LabelViewModel;

class LabelDTOTransformer
{
    public static function fromLabel(Label $label)
    {
        $labelView = new LabelViewModel;

        $labelView->entityName = get_class($label);
        $labelView->id = $label->getId();
        $labelView->name = mb_convert_case($label->getName(), MB_CASE_TITLE, 'UTF-8');

        return $labelView;
    }

    public function fromLabels(array $labels): array
    {
        $labelsView = [];

        foreach($labels as $label) {
            $labelsView[] = $this->fromLabel($label);
        }

        return $labelsView;
    }
}
