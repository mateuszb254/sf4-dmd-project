<?php

namespace App\Article\Repository;

interface ArticleRepositoryInterface
{
    public function findLatestPaginated(int $page, ?int $articleStatus, int $perPage): array;
}
