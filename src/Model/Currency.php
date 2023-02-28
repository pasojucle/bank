<?php

declare(strict_types=1);

namespace App\Model;

class Currency
{
    private int $amount = 0;

    public function __construct(?int $amount)
    {
        $this->amount = $amount;
    }

    public function toString(): string
    {
        return number_format($this->getAmount(), 2) . ' €';
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount * 100;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount / 100;
    }

    public function add(Currency $amountToAdd): self
    {
        $this->amount += $amountToAdd->amount;

        return $this;
    }

    public function sub(Currency $amountToSub): self
    {
        $this->amount -= $amountToSub->amount;

        return $this;
    }
}