<?php

namespace App\Payments\Service\Coins;

/**
 * Basic currency to coins
 * Other currencies than PLN are not supported
 *
 * Implement your own class that implements this interface
 */
class CurrencyToCoinsCalculator implements CurrencyToCoinsCalculatorInterface
{
    public function calculate(string $currency, float $amount): int
    {
        return ceil($amount * (1 + ($amount / 100)));
    }
}
