<?php

namespace App\Promotion\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\Promotion\Form\Model\PromotionCouponUsage;
use App\Promotion\Form\Type\PromotionCouponUsageType;
use App\Promotion\Service\PromotionCouponUsageServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IsGranted("ROLE_USER")
 *
 * @Route("/coupon")
 */
class PromotionCouponController extends AbstractController
{
    /**
     * @Route("/", name="promotion_coupon_index")
     */
    public function index(Request $request, PromotionCouponUsageServiceInterface $couponUsageService): Response
    {
        $form = $this->createForm(PromotionCouponUsageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /** @var PromotionCouponUsage $promotionCoupon */
            $promotionCoupon = $form->getData();

            $couponUsageService->useCoupon($promotionCoupon->getCode(), $this->getUser());

            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'promotion_coupon_usage_success');
            return $this->redirectToRoute('promotion_coupon_index');
        }

        return $this->render('user/promotion/coupon/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
