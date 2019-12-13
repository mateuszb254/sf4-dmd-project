<?php

namespace App\User\Form\Type;

use App\User\Form\Model\BanUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BanUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'user_perm_ban' => BanUser::PERM_BAN_TYPE,
                    'user_temporary_ban' => BanUser::TEMPORARY_BAN_TYPE,
                ],
                'placeholder' => 'not_selected',
            ])
            ->add('reason', TextType::class)
            ->add('banTime', DateTimeType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BanUser::class
        ]);
    }
}
