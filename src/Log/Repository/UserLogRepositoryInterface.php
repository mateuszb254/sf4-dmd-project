<?php

namespace App\Log\Repository;

use App\User\Model\UserInterface;

interface UserLogRepositoryInterface
{
    public function findLatestByType(UserInterface $user, int $count, ?string $fullClassName = null): array;
    public function findAllByType(UserInterface $user, ?string $fullClassName = null): array;
}
