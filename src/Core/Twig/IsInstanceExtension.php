<?php

namespace App\Core\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class IsInstanceExtension extends AbstractExtension
{
    public function isInstanceOf($var, string $instance): bool
    {
        return $var instanceof $instance;
    }

    public function getTests()
    {
        return [
            new TwigTest('instanceof', [
                $this, 'isInstanceOf'
            ])
        ];
    }
}
