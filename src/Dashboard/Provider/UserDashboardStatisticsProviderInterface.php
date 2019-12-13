<?php

namespace App\Dashboard\Provider;

use App\Dashboard\Statistics\UserDashboardStatistics;
use App\User\Model\UserInterface;

interface UserDashboardStatisticsProviderInterface
{
    public function getStatistics(UserInterface $user): UserDashboardStatistics;
}
