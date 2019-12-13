<?php

namespace App\Dashboard\Statistics;

use App\Dashboard\Collection\AuthAttemptsCollection;

class UserDashboardStatistics
{
    protected $authAttempts;

    public function __construct(AuthAttemptsCollection $authAttempts)
    {
        $this->authAttempts = $authAttempts;
    }

    public function getAuthAttempts(): AuthAttemptsCollection
    {
        return $this->authAttempts;
    }
}
