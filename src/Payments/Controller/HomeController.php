<?php

namespace App\Payments\Controller;

use App\Core\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="payments_index")
     */
    public function index(): Response
    {
        return $this->render('user/payments/index.html.twig');
    }
}
