<?php

namespace App\Promotion\Form\Type;

use App\Promotion\Entity\Promotion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionWithCouponCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'name'
            ])
            ->add('coins', NumberType::class, [
                'label' => 'user_coins'
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    Promotion::NORMAL_TYPE => Promotion::NORMAL_TYPE,
                    Promotion::ONE_PER_USER_TYPE => Promotion::ONE_PER_USER_TYPE
                ],
                'label' => 'promotion_type'
            ])
            ->add('expires_confirmation', CheckboxType::class, [
                'label' => 'expires_confirmation',
                'mapped' => false,
                'required' => false,
            ])
            ->add('expires', DateTimeType::class, [
                'format' => DateTimeType::DEFAULT_TIME_FORMAT,
                'date_widget' => 'single_text',
                'label' => 'expiration_data',
                'data' => new \DateTime()
            ])->add('coupons', CollectionType::class, [
                'entry_type' => PromotionCouponType::class,
                'allow_delete' => true,
                'label' => false,
            ]);

        /** displays correctly checkbox value if promotion expires */
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $formEvent) {
            /** @var FormInterface $form */
            $form = $formEvent->getForm();
            /** @var Promotion $promotion */
            $promotion = $form->getData();

            $form->get('expires_confirmation')->setData($promotion->getExpires() instanceof \DateTime);
        });

        /** sets expiration date as null in model data if promotion doesn't expire at the end of form submit */
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $formEvent) {
            /** @var FormInterface $form */
            $form = $formEvent->getForm();
            /** @var Promotion $promotion */
            $promotion = $form->getData();
            /** @var boolean $expiresCheck */
            $expiresCheck = $form->get('expires_confirmation')->getData();

            if (!$expiresCheck) $promotion->setExpires(null);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}
