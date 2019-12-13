<?php

namespace App\User\Controller\Admin;

use App\Core\Controller\AbstractController;
use App\User\Permissions;
use App\User\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IsGranted(Permissions::USER_CAN_BROWSE_SECTION)
 */
final class UserController extends AbstractController
{
    /** @var UserRepository $repository */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/{page}", defaults={"page" : 1}, requirements={"page" : "\d+"}, name="admin_users_index")
     */
    public function index(Request $request, int $page = 1): Response
    {
        $paginatedUsers = $this->repository->findLatestWithRoleGroupPaginated($page);

        return $this->render('admin/user/index.html.twig', [
            'pagination' => $paginatedUsers
        ]);
    }
}
