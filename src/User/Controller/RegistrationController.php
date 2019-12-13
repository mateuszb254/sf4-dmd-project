<?php

namespace App\User\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\User\Form\Type\RegistrationType;
use App\User\Model\UserInterface;
use App\User\Service\RegistrationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController extends AbstractController
{
    /** @var RegistrationService $userRegistration */
    private $userRegistrationService;

    public function __construct(RegistrationService $userRegistrationService)
    {
        $this->userRegistrationService = $userRegistrationService;
    }

    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request): Response
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserInterface $user */
            $user = $form->getData();

            $this->userRegistrationService->register($user);

            $this->addFlash(FlashMessageTypes::SUCCESS, 'registration_success');
            return $this->redirectToRoute('user_registration');
        }

        return $this->render('user/user/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
