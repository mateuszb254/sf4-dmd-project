<?php

namespace App\Character\Repository;

use App\Character\Entity\Character;

interface CharacterRepositoryInterface
{
    public function findByName($name, $mastersExcluded = Character::MASTERS_EXCLUDED): ?Character;
    public function findLatestPaginated(int $page = 1, bool $mastersExcluded = Character::MASTERS_EXCLUDED): array;
    public function findTopCharacters(int $numberOfChars = Character::NUMBER_OF_CHARS_SIDEBAR, bool $mastersExcluded = Character::MASTERS_EXCLUDED): array;
}
