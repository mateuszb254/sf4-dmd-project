<?php

namespace App\User\Repository;

use App\User\Model\UserInterface;

interface UserRepositoryInterface
{
    public function findOneByLogin(string $login): ?UserInterface;

    public function findOneByLoginOrEmail(string $value): ?UserInterface;

    public function findLatestWithRoleGroupPaginated(int $page = 1): array;

    public function countRegisteredToday(): int;
}
