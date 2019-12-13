<?php

namespace App\Payments\Controller\API;

use App\Core\Controller\AbstractController;
use App\Payments\Form\Type\CurrencyToCoinsType;
use App\Payments\Service\Coins\CurrencyToCoinsCalculatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IsGranted("ROLE_USER")
 *
 * @Route("/coins")
 */
class CoinsController extends AbstractController
{
    /** @var CurrencyToCoinsCalculatorInterface $coinsCalculator */
    private $coinsCalculator;

    public function __construct(CurrencyToCoinsCalculatorInterface $coinsCalculator)
    {
        $this->coinsCalculator = $coinsCalculator;
    }

    /**
     * @Route("/calculate-coins", name="api_payments_coins_calculate")
     */
    public function calculate(Request $request): Response
    {
        if (!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CurrencyToCoinsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->json([
                'status' => Response::HTTP_OK,
                'coins' => $this->coinsCalculator->calculate(
                    $form->get('currency')->getData(), $form->get('amount')->getData()
                )
            ], Response::HTTP_OK);
        }

        return $this->json([
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'errors' => $this->getFormErrors($form)
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
