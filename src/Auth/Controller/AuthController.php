<?php

namespace App\Auth\Controller;

use App\Auth\Form\Type\AuthType;
use App\Core\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="auth_login")
     */
    public function userAuth(AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->getAuthForm();

        return $this->render('auth/auth_form.html.twig', [
            'form' => $form->createView(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'last_username' => $authenticationUtils->getLastUsername()
        ]);
    }

    /**
     * @Route("/auth", name="auth_required")
     */
    public function userAuthRequired(Request $request): Response
    {
        return $this->render('auth/authentication_required.html.twig');
    }

    /**
     * @Route("/logout", name="auth_logout")
     */
    public function logout()
    {
        throw new \RuntimeException('You must configure the logout path to be handled by the firewall.');
    }

    private function getAuthForm(): FormInterface
    {
        return $this->createForm(AuthType::class);
    }
}
