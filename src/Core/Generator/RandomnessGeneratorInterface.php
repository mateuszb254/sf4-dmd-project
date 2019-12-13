<?php

namespace App\Core\Generator;

interface RandomnessGeneratorInterface
{
    public function generateUriSafeString(int $length): string;

    public function generateNumeric(int $length): string;

    public function generateInt(int $min, int $max): int;
}
