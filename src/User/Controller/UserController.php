<?php

namespace App\User\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\Dashboard\Provider\UserDashboardStatisticsProviderInterface;
use App\User\Form\Model\ChangePassword;
use App\User\Form\Type\ChangeCharRemovalCodeType;
use App\User\Form\Type\ChangePasswordType;
use App\User\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
final class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_panel")
     */
    public function panel(Request $request, UserDashboardStatisticsProviderInterface $dashboardStatistics): Response
    {
        $user = $this->getUser();

        return $this->render('user/user/panel.html.twig', [
            'user' => $user,
            'user_statistics' => $dashboardStatistics->getStatistics($user)
        ]);
    }

    /**
     * @Route("/change-password", name="user_change_password")
     */
    public function changePassword(Request $request): Response
    {
        $changePassword = new ChangePassword();

        $form = $this->createForm(ChangePasswordType::class, $changePassword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var UserInterface $user */
            $user = $this->getUser();
            /** @var ChangePassword $changePassword */
            $changePassword = $form->getData();

            $user->setPlainPassword($changePassword->getNewPassword());

            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'password_change_success');
            return $this->redirectToRoute('user_change_password');
        }

        return $this->render('user/user/change_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/change-char-removal-code", name="user_change_char_removal_code")
     */
    public function changeCharRemovalCode(Request $request): Response
    {
        $form = $this->createForm(ChangeCharRemovalCodeType::class);
        $form->handleRequest($request);

        return $this->render('user/user/change_char_removal_code.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
