<?php

namespace App\Core\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    /**
     * default_locale defined in translation.yaml
     *
     * @var string $defaultLocale
     */
    private $defaultLocale;

    /**
     * supported_locales defined in app.yaml
     *
     * @var array $supportedLocales
     */
    private $supportedLocales;

    /**
     * LocaleSubscriber constructor.
     * @param string $defaultLocale
     * @param array $supportedLocales
     */
    public function __construct(string $defaultLocale, array $supportedLocales)
    {
        $this->defaultLocale = $defaultLocale;
        $this->supportedLocales = $supportedLocales;
    }

    /**
     * Method set locale
     *
     * If preferred locale is not set, it takes from Http Header "Accept-Language" preferred. In case, we cannot match
     * any supported language it will be set according 'kernel.default_locale'.
     *
     * If there is an _locale get parameter, it will be validated. If _locale is not found in the list of supported
     * languages, it sets as 'kernel.default_locale'.
     */
    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return false;
        }

        $request = $event->getRequest();

        $preferredLanguages = $request->getLanguages();
        $currentLocale = $request->getSession()->get('_locale');

        if (null === $currentLocale) {
            $request->getSession()->set(
                '_locale',
                $this->findSupportedLocaleFromPreferred($preferredLanguages) ?? $this->defaultLocale
            );
        }

        $requestedLocale = $request->get('_locale');

        if ($requestedLocale !== null) {
            $request->getSession()->set(
                '_locale',
                $this->isLocaleSupported($requestedLocale) ?
                    $requestedLocale : $this->findSupportedLocaleFromPreferred($preferredLanguages) ?? $this->defaultLocale
            );

            return $event->setResponse(
                new RedirectResponse($request->getPathInfo())
            );
        }

        $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));

        return true;
    }

    /**
     * It checks if given string is supported locale
     *
     * @param string $locale
     * @return bool
     */
    private function isLocaleSupported(string $locale): bool
    {
        return in_array($locale, $this->supportedLocales);
    }

    /**
     * It tries to find first supported language from Accept-Language http header
     *
     * @param array $preferredLanguages
     * @return null|string
     */
    private function findSupportedLocaleFromPreferred(array $preferredLanguages): ?string
    {
        foreach ($preferredLanguages as $preferredLanguage) {
            if ($this->isLocaleSupported($preferredLanguage)) return $preferredLanguage;
        }

        return null;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                'onKernelRequest', 18
            ]
        ];
    }
}
