<?php

namespace App\Payments\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CurrencyToCoins
{
    /**
     * @var string $currency
     */
    private $currency;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(value=10)
     *
     * @var float $amount
     */
    private $amount;

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return self
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return self
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
