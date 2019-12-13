<?php

namespace App\Dashboard\Provider;

use App\Dashboard\Statistics\AdminDashboardStatistics;
use App\User\Repository\UserRepositoryInterface;

class AdminDashboardStatisticsProvider implements AdminDashboardStatisticsProviderInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getStatistics(): AdminDashboardStatistics
    {
        return new AdminDashboardStatistics(
            $this->userRepository->countRegisteredToday()
        );
    }
}
