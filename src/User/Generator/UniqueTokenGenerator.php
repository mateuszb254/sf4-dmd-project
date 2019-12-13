<?php

namespace App\User\Generator;

use App\Core\Generator\RandomnessGeneratorInterface;
use App\Core\Generator\UniquenessGeneratorInterface;
use App\Core\UniqueChecker\UniqueCheckerInterface;

final class UniqueTokenGenerator implements UniquenessGeneratorInterface
{
    protected const TOKEN_LENGTH = 25;

    /** @var RandomnessGeneratorInterface $generator */
    private $generator;

    /** @var UniqueCheckerInterface $checker */
    private $checker;

    public function __construct(RandomnessGeneratorInterface $randomnessGenerator, UniqueCheckerInterface $checker)
    {
        $this->generator = $randomnessGenerator;
        $this->checker = $checker;
    }

    public function generate(): string
    {
        do {
            $token = $this->generator->generateUriSafeString(self::TOKEN_LENGTH);
        } while (!$this->checker->isUnique($token));

        return $token;
    }
}
