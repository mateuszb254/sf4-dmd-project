<?php

namespace App\Promotion\Controller\Admin;

use App\Core\Controller\AbstractController;
use App\Promotion\Entity\Promotion;
use App\Promotion\Form\Type\PromotionWithCouponCollectionType;
use App\Promotion\Repository\PromotionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromotionController extends AbstractController
{
    /** @var PromotionRepository */
    protected $promotionRepository;

    public function __construct(PromotionRepository $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    /**
     * @Route("/", name="admin_promotion_index")
     */
    public function index(): Response
    {
        return $this->render('admin/promotion/index.html.twig', [
            'promotionsData' => $this->promotionRepository->findAllWithStatistics()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_promotion_edit")
     */
    public function edit(Request $request, Promotion $promotion)
    {
        $form = $this->createForm(PromotionWithCouponCollectionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('admin_promotion_index');
        }

        return $this->render('admin/promotion/edit.html.twig', [
            'form' => $form->createView(),
            'promotion' => $promotion
        ]);
    }
}
