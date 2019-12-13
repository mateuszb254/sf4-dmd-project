<?php

namespace App\User\Controller\Admin;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\Dashboard\Provider\UserDashboardStatisticsProviderInterface;
use App\User\Entity\User;
use App\User\Form\Model\BanUser;
use App\User\Form\Type\BanUserType;
use App\User\Form\Type\EditUserType;
use App\User\Permissions;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ProfileController extends AbstractController
{
    /** @var UserDashboardStatisticsProviderInterface $userDashboard */
    protected $userDashboard;

    public function __construct(UserDashboardStatisticsProviderInterface $dashboard)
    {
        $this->userDashboard = $dashboard;
    }

    /**
     * @IsGranted(Permissions::USER_CAN_BROWSE_SECTION)
     * @Route("/{login}/profile", requirements={"login" : "[a-zA-Z0-9_]+"}, name="admin_user_profile")
     */
    public function profile(Request $request, User $user): Response
    {
        $em = $this->getDoctrine()->getManager();

        $editUserForm = $this->createForm(EditUserType::class, $user);
        $editUserForm->handleRequest($request);

        if ($editUserForm->isSubmitted() && $editUserForm->isValid()) {
            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'admin_user_edited');
            return $this->redirectToRoute('admin_user_profile', [
                'login' => $user->getLogin()
            ]);
        }

        return $this->render('admin/user/profile.html.twig', [
            'user' => $user,
            'user_statistics' => $this->userDashboard->getStatistics($user),
            'editUserForm' => $editUserForm->createView(),
        ]);
    }

    /**
     * @IsGranted(Permissions::USER_CAN_BAN_USER)
     * @Route("/{login}/ban", requirements={"login" : "[a-zA-Z0-9]+"}, name="admin_user_ban")
     */
    public function banUser(Request $request, User $user): Response
    {

    }

    /**
     * @IsGranted(Permissions::USER_CAN_BAN_USER)
     * @Route("/{login}/unban", name="admin_user_unban")
     */
    public function unbanUser(Request $request, User $user): Response
    {
        $em = $this->getDoctrine()->getManager();

        $user->setStatus(User::STATUS_OK);
        $user->setBanTime(null);
        $user->setBanReason(null);

        $em->flush();

        return $this->redirectToRoute('admin_user_profile', [
            'login' => $user->getLogin()
        ]);
    }
}
