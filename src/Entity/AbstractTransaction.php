<?php

namespace App\Entity;

use App\Entity\Label;
use App\Entity\Account;
use App\Entity\Category;
use Doctrine\ORM\Mapping as ORM;

class AbstractTransaction
{
    #[ORM\ManyToOne(inversedBy: 'transactions')]
    protected ?Label $label;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    protected ?Category $category = null;

    #[ORM\Column]
    protected int $amount = 0;

    #[ORM\ManyToOne]
    protected ?Account $debitAccount = null;

    #[ORM\ManyToOne]
    protected ?Account $creditAccount = null;

    public function getLabel(): Label
    {
        return $this->label;
    }

    public function setLabel(?Label $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDebitAccount(): ?Account
    {
        return $this->debitAccount;
    }

    public function setDebitAccount(?Account $debitAccount): self
    {
        $this->debitAccount = $debitAccount;

        return $this;
    }

    public function getCreditAccount(): ?Account
    {
        return $this->creditAccount;
    }

    public function setCreditAccount(?Account $creditAccount): self
    {
        $this->creditAccount = $creditAccount;

        return $this;
    }
}
