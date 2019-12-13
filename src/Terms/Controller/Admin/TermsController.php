<?php

namespace App\Terms\Controller\Admin;

use App\Core\Controller\AbstractController;
use App\Terms\Type\Type\TermsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IsGranted("ROLE_USER")
 */
final class TermsController extends AbstractController
{
    /**
     * @Route("/", name="admin_terms_index")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(TermsType::class);

        return $this->render('admin/terms/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
