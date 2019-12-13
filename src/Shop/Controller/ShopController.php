<?php

namespace App\Shop\Controller;

use App\Core\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IsGranted("ROLE_USER")
 */
class ShopController extends AbstractController
{
    /**
     * @Route("/", name="shop_index")
     */
    public function index(): Response
    {
        return $this->render('user/shop/index.html.twig');
    }
}
