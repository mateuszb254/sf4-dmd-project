<?php

namespace App\Promotion\Form\Type;

use App\Promotion\Form\Model\PromotionCouponUsage;
use App\Promotion\Form\Transformer\CouponToStringTransformer;
use App\Promotion\Repository\PromotionCouponRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GroupSequence;

class PromotionCouponUsageType extends AbstractType
{
    protected $couponRepository;
    protected $couponTransformer;

    public function __construct(PromotionCouponRepository $couponRepository, CouponToStringTransformer $couponTransformer)
    {
        $this->couponRepository = $couponRepository;
        $this->couponTransformer = $couponTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', TextType::class, [
            'label' => 'promotion_coupon',
            'help' => 'promotion_coupon_box_description'
        ]);

        $builder->get('code')->addModelTransformer($this->couponTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PromotionCouponUsage::class,
            'validation_groups' => new GroupSequence(['PromotionCouponUsage', 'promotion_coupon_usable_check'])
        ]);
    }
}
