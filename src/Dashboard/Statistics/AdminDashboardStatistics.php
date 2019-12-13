<?php


namespace App\Dashboard\Statistics;


class AdminDashboardStatistics
{
    /** @var int */
    protected $registeredToday;

    public function __construct(int $registeredToday)
    {
        $this->registeredToday = $registeredToday;
    }

    public function getRegisteredToday(): int
    {
        return $this->registeredToday;
    }
}
