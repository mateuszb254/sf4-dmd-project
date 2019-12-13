<?php

namespace App\Promotion\Form\Type;

use App\Promotion\Entity\PromotionCoupon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionCouponType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', TextType::class, [
            'label' => false,
            'attr' => [
                'readonly' => true,
            ]
        ]);

        /** prevent to override data despite the attribute 'readonly' is set */
        $builder->get('code')->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $formEvent) {
            $formEvent->setData($formEvent->getForm()->getViewData());
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', PromotionCoupon::class);
    }
}
