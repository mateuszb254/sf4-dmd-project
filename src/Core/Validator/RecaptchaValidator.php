<?php

namespace App\Core\Validator;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * More https://developers.google.com/recaptcha/docs/verify
 */
final class RecaptchaValidator extends ConstraintValidator
{
    /**
     * @var string API_URL Google's API url
     */
    protected const API_URI = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Set in app.yaml as 'repcatcha.public_key'
     *
     * @var string $secretKey Public key provided by Google
     */
    private $secretKey;

    /**
     * Specifies if recaptcha should be checked
     * Set in app.yaml as 'recaptcha.enabled'
     *
     * @var bool $enabled
     */
    private $enabled;

    /**
     * @var RequestStack $requestStack
     */
    private $requestStack;

    /**
     * RecaptchaValidator constructor.
     * @param string $secretKey
     * @param bool $enabled
     * @param RequestStack $requestStack
     */
    public function __construct(string $secretKey, bool $enabled, RequestStack $requestStack)
    {
        $this->secretKey = $secretKey;
        $this->enabled = $enabled;
        $this->requestStack = $requestStack;
    }

    /**
     * Takes g-recaptcha-response and sends it to google's api for verifying
     *
     * @param mixed $value
     * @param Constraint $constraint
     * @return bool
     */
    public function validate($value, Constraint $constraint)
    {
        $request = $this->requestStack->getMasterRequest();

        /** Do not validate if recatpcha is disabled */
        if (!$this->enabled) return true;

        $gRecaptchaResponse = $request->get('g-recaptcha-response');

        if ($gRecaptchaResponse === null || !$this->getGoogleResponse($gRecaptchaResponse)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }

    /**
     * Takes response from google's api
     *
     * @param string $gRecaptchaResponse
     * @return bool
     */
    private function getGoogleResponse(string $gRecaptchaResponse): bool
    {
        $googleResponseJson = file_get_contents(self::API_URI . '?secret=' . $this->secretKey . '&response=' . $gRecaptchaResponse);
        $googleResponse = json_decode($googleResponseJson);

        return $googleResponse->success;
    }
}
