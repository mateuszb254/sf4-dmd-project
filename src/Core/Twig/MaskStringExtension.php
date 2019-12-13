<?php

namespace App\Core\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MaskStringExtension extends AbstractExtension
{
    public const STRING_TYPE = 0;
    public const EMAIL_TYPE = 1;

    /** @var int percentage of string to mask (rounded down) */
    protected const DEFAULT_MASK_RATIO = 50;

    public function mask(string $string, int $type = self::STRING_TYPE, int $ratio = self::DEFAULT_MASK_RATIO)
    {
        switch ($type) {
            case self::STRING_TYPE:
                return $this->maskString($string, $ratio);
            case self::EMAIL_TYPE:
                return $this->maskEmail($string, $ratio);
            default:
                throw new \UnexpectedValueException('
                    Masking string type is not supported. Check available in ' . __CLASS__ . '
                ');
        }
    }

    protected function maskString(string $string, int $ratio)
    {
        $charactersToMask = ceil(
            mb_strlen($string) * $ratio / 100
        );

        return substr_replace($string, str_repeat('*', $charactersToMask), -$charactersToMask);
    }

    protected function maskEmail(string $email, int $ratio)
    {
        $splitEmail = preg_split('/[@.]/', $email);

        if (count($splitEmail) !== 3) return $this->maskString($email, $ratio);

        list($name, $domainName, $domainExtension) = $splitEmail;

        return $this->maskString($name, $ratio) . '@' . $this->maskString($domainName, $ratio) . '.' . $domainExtension;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('mask', [$this, 'mask'])
        ];
    }
}
