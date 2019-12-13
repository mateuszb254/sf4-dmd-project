<?php

namespace App\Promotion\Controller\Admin;

use App\Core\Controller\AbstractController;
use App\Core\Util\Flash\FlashMessageTypes;
use App\Promotion\Entity\Promotion;
use App\Promotion\Entity\PromotionCoupon;
use App\Promotion\Form\Model\PromotionCouponGenerate;
use App\Promotion\Form\Type\PromotionCouponGeneratorType;
use App\Promotion\Generator\PromotionCouponGeneratorInterface;
use App\Promotion\Repository\PromotionCouponRepository;
use App\Promotion\Repository\PromotionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PromotionCouponController extends AbstractController
{
    /** @var PromotionRepository $repository */
    private $couponRepository;

    /** @var PromotionCouponRepository $repository */
    private $promotionRepository;

    /** @var PromotionCouponGeneratorInterface $promotionCouponGenerator */
    private $promotionCouponGenerator;

    public function __construct(
        PromotionRepository $promotionRepository,
        PromotionCouponRepository $couponRepository,
        PromotionCouponGeneratorInterface $promotionCouponGenerator
    )
    {
        $this->promotionRepository = $promotionRepository;
        $this->couponRepository = $couponRepository;
        $this->promotionCouponGenerator = $promotionCouponGenerator;
    }

    /**
     * @Route("/coupons/{page}", requirements={"page" : "\d+"}, name="admin_promotion_coupon_index")
     */
    public function index(Request $request, int $page = 1): Response
    {
        $promotionCouponGenerate = new PromotionCouponGenerate();

        $form = $this->createForm(PromotionCouponGeneratorType::class, $promotionCouponGenerate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            /** @var PromotionCoupon[] $promotionCoupons */
            $promotionCoupons = $this->promotionCouponGenerator->generate(
                $promotionCouponGenerate->getAmount()
            );

            $managedPromotion = $promotionCouponGenerate->getPromotion() ?? $promotionCouponGenerate->getNewPromotion();
            $managedPromotion->addCoupons($promotionCoupons, $this->getUser());

            $em->persist($managedPromotion);
            $em->flush();

            $this->addFlash(FlashMessageTypes::SUCCESS, 'admin_promotion_coupon_index');
            return $this->redirectToRoute('admin_promotion_coupon_index');
        }


        return $this->render('admin/promotion/coupon/index.html.twig', [
            'form' => $form->createView(),
            'activePromotionsData' => $this->promotionRepository->findAllActiveWithStatistics(),
            'pagination' => $this->couponRepository->findLatestPaginated($page)
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_promotion_delete"))
     */
    public function delete(Request $request, Promotion $coupon)
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_promotion_coupon_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($coupon);
        $em->flush();

        return $this->redirectToRoute('admin_promotion_coupon_index');
    }
}
