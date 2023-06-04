<?php

declare(strict_types=1);

namespace App\Model;

class Currency
{
    private int $amount = 0;

    public function __construct(int $amount = 0)
    {
        $this->amount = $amount;
    }

    public function toString(): string
    {
        return number_format($this->getAmount(), 2, ',', ' ');
    }

    public function setAmount(float $amount): self
    {
        $this->amount = (int) $amount * 100;
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

    static function fromString(string $amount): self
    {
        $value = 0;
        if (1 === preg_match('#^-*(\d+),*(\d*)$#', $amount, $matches)) {
            $value = (float) sprintf('%d.%d', $matches[1], $matches[2]) * 100;
        }
        $currency = new self();
        $currency->setAmount($value);

        return $currency;
    }
}