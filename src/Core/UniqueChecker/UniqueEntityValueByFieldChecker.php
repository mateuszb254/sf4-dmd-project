<?php

namespace App\Core\UniqueChecker;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

final class UniqueEntityValueByFieldChecker implements UniqueCheckerInterface
{
    private $repository;
    private $fieldName;

    public function __construct(ServiceEntityRepository $repository, string $fieldName)
    {
        $this->repository = $repository;
        $this->fieldName = $fieldName;
    }

    public function isUnique(string $value): bool
    {
        return null === $this->repository->findOneBy([$this->fieldName => $value]);
    }
}
