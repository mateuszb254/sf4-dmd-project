<?php

namespace App\Promotion\Form\Type;

use App\Promotion\Entity\Promotion;
use App\Promotion\Form\Model\PromotionCouponGenerate;
use App\User\Permissions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionCouponGeneratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('amount', NumberType::class, [
            'label' => 'amount'
        ])->add('promotion', EntityType::class, [
            'class' => Promotion::class,
            'label' => 'promotion',
            'required' => false,
            'placeholder' => 'promotion_select'
        ])->add('newPromotion', PromotionType::class, [
            'required' => false,
            'label' => 'promotion_add',
            'is_granted' => Permissions::PROMOTION_CAN_ADD
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PromotionCouponGenerate::class,
            'is_granted' => Permissions::PROMOTION_COUPON_CAN_GENERATE,
            'validation_groups' => function (FormInterface $form) {
                /** @var PromotionCouponGenerate $promotionCouponGenerate */
                $promotionCouponGenerate = $form->getData();

                $commonGroups = ['Default', 'PromotionCouponGenerate'];

                return $promotionCouponGenerate->getPromotion() instanceof Promotion ?
                    array_merge($commonGroups, ['existing_promotion']) : array_merge($commonGroups, ['Promotion']);
            }
        ]);
    }
}
