<?php

namespace App\Payments\Controller;

use App\Core\Controller\AbstractController;
use App\Payments\Form\Type\CurrencyToCoinsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IsGranted("ROLE_USER")
 *
 * @Route("/paysafecard")
 */
class PaySafeCardController extends AbstractController
{
    /**
     * @Route("/", name="payments_paysafecard_index")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(CurrencyToCoinsType::class);

        $form->handleRequest($request);

        return $this->render('user/payments/paysafecard/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
