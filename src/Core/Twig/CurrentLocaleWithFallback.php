<?php

namespace App\Core\Twig;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CurrentLocaleWithFallback extends AbstractExtension
{
    /**
     * The default locale from app\config\app.yaml 'locale'
     *
     * @var string $defaultLocale
     */
    protected $defaultLocale;

    /**
     * @var SessionInterface $session
     */
    protected $session;

    public function __construct(SessionInterface $session, string $defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
        $this->session = $session;
    }

    public function getLocales(): array
    {
        return [
            'currentLocale' => $this->session->get('_locale'),
            'defaultLocale' => $this->defaultLocale
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('localeWithFallback', [
                $this, 'getLocales'
            ])
        ];
    }
}
