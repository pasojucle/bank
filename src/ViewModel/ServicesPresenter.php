<?php

declare(strict_types=1);

namespace App\ViewModel;

use Symfony\Contracts\Translation\TranslatorInterface;


class ServicesPresenter
{
    public function __construct(
        public TranslatorInterface $translator
    )
    {

    }

}