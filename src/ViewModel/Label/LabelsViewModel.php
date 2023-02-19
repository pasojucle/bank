<?php

declare(strict_types=1);

namespace App\ViewModel\Label;

use App\ViewModel\Label\LabelViewModel;

class LabelsViewModel
{
    public ?array $labels = [];

    public static function fromLabels(array $labels): LabelsViewModel
    {
        $labelsViewModel = [];

        foreach ($labels as $label) {
            $labelsViewModel[] = LabelViewModel::fromLabel($label);
        }

        $labelsView = new self();
        $labelsView->labels = $labelsViewModel;

        return $labelsView;
    }
}
