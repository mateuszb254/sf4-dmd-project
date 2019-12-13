<?php

namespace App\Dashboard\Provider;

use App\Dashboard\Collection\AuthAttemptsCollection;
use App\Dashboard\Statistics\UserDashboardStatistics;
use App\Log\Entity\AuthenticationUserLog;
use App\Log\Entity\UserLog;
use App\Log\Repository\UserLogRepositoryInterface;
use App\User\Model\UserInterface;

class UserDashboardStatisticsProvider implements UserDashboardStatisticsProviderInterface
{
    protected $userLogRepository;

    public function __construct(UserLogRepositoryInterface $userLogRepository)
    {
        $this->userLogRepository = $userLogRepository;
    }

    public function getStatistics(UserInterface $user): UserDashboardStatistics
    {
        return new UserDashboardStatistics(
            new AuthAttemptsCollection(
                $this->userLogRepository->findLatestByType($user, UserLog::PER_PAGE, AuthenticationUserLog::class)
            )
        );
    }
}
