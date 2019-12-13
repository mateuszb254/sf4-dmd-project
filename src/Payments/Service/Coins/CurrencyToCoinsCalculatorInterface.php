<?php

namespace App\Payments\Service\Coins;

interface CurrencyToCoinsCalculatorInterface
{
    public function calculate(string $currency, float $amount): int;
}
