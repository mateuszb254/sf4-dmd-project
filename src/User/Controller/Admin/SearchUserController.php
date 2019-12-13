<?php

namespace App\User\Controller\Admin;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\User\Model\UserInterface;
use App\User\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
final class SearchUserController extends AbstractController
{
    /** @var UserRepository $repository */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/search", name="admin_users_search")
     */
    public function search(Request $request): Response
    {
        if ($search = $request->get('search')) {
            /** @var UserInterface|null $user */
            $user = $this->repository->findOneByLoginOrEmail($search);

            if (!$user) {
                $this->addFlash(FlashMessageTypes::FAILURE, 'user_not_found');
                return $this->redirectToRoute('admin_users_index');
            }

            return $this->redirectToRoute('admin_users_profile', [
                'login' => $user->getLogin()
            ]);
        }

        return $this->redirectToRoute('admin_users_index');
    }
}
