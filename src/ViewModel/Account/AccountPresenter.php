<?php

declare(strict_types=1);

namespace App\ViewModel\Account;

use App\Entity\Account;
use App\ViewModel\AbstractPresenter;
use App\ViewModel\Account\AccountViewModel;

class AccountPresenter extends AbstractPresenter
{
    private $viewModel;

    public function present(?Account $account): void
    {
        if (null !== $account) {
            $this->viewModel = AccountViewModel::fromAccount($account);
        } else {
            $this->viewModel = new AccountViewModel();
        }
    }

    public function viewModel(): AccountViewModel
    {
        return $this->viewModel;
    }
}
