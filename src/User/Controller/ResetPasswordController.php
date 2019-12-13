<?php

namespace App\User\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\User\Event\UserEvent;
use App\User\Form\Model\PasswordResetRequest;
use App\User\Form\Type\RequestPasswordResetType;
use App\User\Form\Type\ResetPasswordType;
use App\User\Model\UserInterface;
use App\User\Repository\UserRepository;
use App\User\Service\ResetPasswordTokenService;
use App\User\UserEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ResetPasswordController extends AbstractController
{
    /** @var UserRepository $repository */
    private $repository;

    /** @var ResetPasswordTokenService $userManipulator */
    private $resetPasswordTokenService;

    public function __construct(UserRepository $repository, ResetPasswordTokenService $resetPasswordTokenService)
    {
        $this->repository = $repository;
        $this->resetPasswordTokenService = $resetPasswordTokenService;
    }

    /**
     * @Route("/reset-password", name="user_request_password_reset")
     */
    public function requestPasswordResetToken(Request $request): Response
    {
        $passwordResetRequest = new PasswordResetRequest();

        $form = $this->createForm(RequestPasswordResetType::class, $passwordResetRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PasswordResetRequest $passwordReset */
            $passwordReset = $form->getData();

            /** @var UserInterface $user */
            $user = $this->repository->findOneBy(['email' => $passwordReset->getEmail()]);

            if ($user === null) {
                throw new \LogicException(
                    'Cannot handle the request with non-existent user. Form validation should have prevented that'
                );
            }

            $this->resetPasswordTokenService->prepareResetPasswordToken($user);

            $this->dispatchEvent(new UserEvent($user), UserEvents::RESET_PASSWORD_TOKEN_REQUESTED);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'request_password_reset_success');
            return $this->redirectToRoute('user_request_password_reset');
        }

        return $this->render('user/user/request_password_reset.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reset-password/{token}", name="user_reset_password")
     */
    public function resetPassword(Request $request, string $token): Response
    {
        /** @var UserInterface $user */
        $user = $this->repository->findOneBy(['passwordResetToken' => $token]);

        $em = $this->getDoctrine()->getManager();

        if (null === $user) {
            throw $this->createNotFoundException('Token not found.');
        }

        if ($user->isResetPasswordTokenExpired()) {
            $this->resetPasswordTokenService->handleTokenExpired($user);
            $em->flush();

            $this->addFlash(FlashMessageTypes::FAILURE, 'password_reset_token_expired');
            return $this->redirectToRoute('user_request_password_reset');
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resetPasswordTokenService->resetPassword($user, $form->get('password')->getData());

            $this->dispatchEvent(new UserEvent($user), UserEvents::RESET_PASSWORD_TOKEN_SUCCESS);

            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'password_reset_success');
            return $this->redirectToRoute('homepage');
        }


        return $this->render('user/user/password_reset.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
