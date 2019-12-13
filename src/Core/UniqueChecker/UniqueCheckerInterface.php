<?php


namespace App\Core\UniqueChecker;


interface UniqueCheckerInterface
{
    public function isUnique(string $value): bool;
}
