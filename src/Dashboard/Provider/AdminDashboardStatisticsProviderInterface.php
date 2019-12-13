<?php

namespace App\Dashboard\Provider;

use App\Dashboard\Statistics\AdminDashboardStatistics;

interface AdminDashboardStatisticsProviderInterface
{
    public function getStatistics(): AdminDashboardStatistics;
}
