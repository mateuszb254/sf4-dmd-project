<?php

namespace App\User\Controller\Admin;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\User\Entity\RoleGroup;
use App\User\Form\Model\AssignUserToRoleGroup;
use App\User\Form\Type\AssignUsernameToRoleGroupType;
use App\User\Form\Type\RoleGroupCollectionType;
use App\User\Form\Type\RoleGroupType;
use App\User\Repository\RoleGroupRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IsGranted("ROLE_GLOBAL_ADMIN")
 *
 * @Route("/role-group")
 */
final class RoleGroupController extends AbstractController
{
    /** @var RoleGroupRepository $repository */
    private $repository;

    public function __construct(RoleGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="admin_users_role_group_index")
     */
    public function index(Request $request): Response
    {
        $roleGroupsForm = $this->createForm(RoleGroupType::class, $roleGroup = new RoleGroup());
        $assignUserToRoleGroupForm = $this->createForm(AssignUsernameToRoleGroupType::class, $assignUserToRoleGroup = new AssignUserToRoleGroup());

        if ($this->handleNewRoleGroupForm($request, $roleGroupsForm, $roleGroup) ||
            $this->handleAssignUserToRoleForm($request, $assignUserToRoleGroupForm, $assignUserToRoleGroup)) {
            return $this->redirectToRoute('admin_users_role_group_index');
        }

        return $this->render('admin/user/role_group/index.html.twig', [
            'roleGroups' => $this->repository->findAllWithAssignedUsers(),
            'assignRoleForm' => $assignUserToRoleGroupForm->createView(),
            'roleGroupsForm' => $roleGroupsForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", requirements={"id" : "\d+"}, name="admin_users_role_group_edit")
     */
    public function edit(Request $request, RoleGroup $roleGroup)
    {
        $roleGroupsForm = $this->createForm(RoleGroupType::class, $roleGroup);
        $roleGroupsForm->handleRequest($request);

        if ($roleGroupsForm->isSubmitted() && $roleGroupsForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'user_role_group_edit_success');
            return $this->redirectToRoute('admin_users_role_group_index');
        }

        return $this->render('admin/user/role_group/edit.html.twig', [
            'form' => $roleGroupsForm->createView()
        ]);
    }

    /**
     * @Route("/{id}/delete", requirements={"id" : "\d+"}, name="admin_users_role_group_delete")
     */
    public function delete(Request $request, RoleGroup $roleGroup)
    {
        if ($this->isCsrfTokenValid('delete', $request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($roleGroup);

            $em->flush();
        }

        return $this->redirectToRoute('admin_users_role_group_index');
    }

    /**
     * @param Request $request
     * @param FormInterface $roleGroupsForm
     * @param RoleGroup $roleGroup
     * @return bool
     */
    private function handleNewRoleGroupForm(Request $request, FormInterface $roleGroupsForm, RoleGroup $roleGroup): bool
    {
        $roleGroupsForm->setData($roleGroup);
        $roleGroupsForm->handleRequest($request);

        if ($roleGroupsForm->isSubmitted() && $roleGroupsForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($roleGroup);
            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'success');

            return true;
        }

        return false;
    }

    /**
     * @param Request $request
     * @param FormInterface $assignUserToRoleForm
     * @param AssignUserToRoleGroup $assignUserToRoleGroup
     * @return bool
     */
    private function handleAssignUserToRoleForm(Request $request, FormInterface $assignUserToRoleForm, AssignUserToRoleGroup $assignUserToRoleGroup): bool
    {
        $assignUserToRoleForm->setData($assignUserToRoleGroup);
        $assignUserToRoleForm->handleRequest($request);

        if ($assignUserToRoleForm->isSubmitted() && $assignUserToRoleForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user = $assignUserToRoleGroup->getUser();
            $user->setRoleGroup($assignUserToRoleGroup->getRoleGroup());

            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'success');

            return true;
        }

        return false;
    }
}
