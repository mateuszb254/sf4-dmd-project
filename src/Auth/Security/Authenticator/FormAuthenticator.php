<?php

namespace App\Auth\Security\Authenticator;

use App\Auth\Form\Type\AuthType;
use App\Auth\Security\Exception\AccountBanned;
use App\User\Model\UserInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface as BaseUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class FormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $passwordEncoder;
    private $formFactory;
    private $urlGenerator;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        FormFactoryInterface $formFactory,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(Request $request)
    {
        $form = $this->getAuthForm()->handleRequest($request);

        return $form->isSubmitted() && $form->isValid();
    }

    public function getCredentials(Request $request)
    {
        $credentials = $this->getAuthForm()
            ->handleRequest($request)
            ->getData();

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['login']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): BaseUser
    {
        try {
            $user = $userProvider->loadUserByUsername($credentials['login']);
        } catch (UsernameNotFoundException $exception) {
            throw new BadCredentialsException();
        }

        if (!$user) {
            throw new BadCredentialsException();
        }

        return $user;
    }

    public function checkCredentials($credentials, BaseUser $user): bool
    {
        if (!$user instanceof UserInterface) {
            throw new UnsupportedUserException();
        }

        if (!$this->passwordEncoder->isPasswordValid($user, $credentials['plainPassword'])) {
            throw new BadCredentialsException();
        }

        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->hasSession()) {
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        }

        return new RedirectResponse($this->urlGenerator->generate('homepage'));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('homepage'));
    }

    /**
     * Returns the path to controller which renders view with information that a section requires authentication
     * instead of login url path.
     *
     * @return string
     */
    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate('auth_required');
    }


    protected function getAuthForm()
    {
        return $this->formFactory->create(AuthType::class);
    }
}
