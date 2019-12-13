<?php

namespace App\User\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\User\Form\Model\ChangeEmail;
use App\User\Form\Type\ChangeEmailRequestType;
use App\User\Form\Type\ChangeEmailType;
use App\User\Model\UserInterface;
use App\User\Repository\UserRepository;
use App\User\Service\EmailChangeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EmailChangeController extends AbstractController
{
    /** @var UserRepository $repository */
    private $repository;

    /** @var EmailChangeService $emailChangeService */
    private $emailChangeService;

    public function __construct(UserRepository $repository, EmailChangeService $emailChangeService)
    {
        $this->repository = $repository;
        $this->emailChangeService = $emailChangeService;
    }

    /**
     * @IsGranted("ROLE_USER")
     *
     * @Route("/change-email", name="user_change_email_request")
     */
    public function changeEmailRequest(Request $request): Response
    {
        $form = $this->createForm(ChangeEmailRequestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var UserInterface $user */
            $user = $this->getUser();

            $this->emailChangeService->handleEmailChangeRequest($user);

            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'email_change_request_success');
            return $this->redirectToRoute('user_change_email_request');
        }

        return $this->render('user/user/change_email_request.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/change-email/{token}", name="user_change_email")
     */
    public function changeEmail(Request $request, string $token): Response
    {
        /** @var UserInterface $user */
        $user = $this->repository->findOneBy(['emailChangeToken' => $token]);

        if (null === $user) {
            throw $this->createNotFoundException('Token not found.');
        }

        $em = $this->getDoctrine()->getManager();

        if ($user->isChangeEmailTokenExpired()) {
            $this->emailChangeService->handleTokenExpired($user);

            $em->flush();

            $this->addFlash(FlashMessageTypes::FAILURE, 'password_reset_token_expired');
            return $this->redirectToRoute('user_request_password_reset');
        }

        $form = $this->createForm(ChangeEmailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ChangeEmail $emailChange */
            $emailChange = $form->getData();

            $this->emailChangeService->changeEmail($user, $emailChange->getNewEmail());

            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'email_change_success');
            return $this->redirectToRoute('user_panel');
        }


        return $this->render('user/user/change_email.html.twig', ['form' => $form->createView()]);
    }
}
