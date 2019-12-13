<?php

namespace App\Promotion\Generator;

use App\Core\Generator\RandomnessGeneratorInterface;
use App\Core\Generator\UniquenessGeneratorInterface;
use App\Core\UniqueChecker\UniqueCheckerInterface;

final class UniquePromotionCouponGenerator implements UniquenessGeneratorInterface
{
    protected const CODE_LENGTH = 8;

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
            $token = mb_strtoupper($this->generator->generateUriSafeString(self::CODE_LENGTH));
        } while (!$this->checker->isUnique($token));

        return $token;
    }
}
