<?php

namespace App\User\Form\Type;

use App\User\Form\Model\ChangeEmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangeEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class, [
                'label' => 'password'
            ])
            ->add('newEmail', RepeatedType::class, [
                'type' => EmailType::class,
                'first_options' => [
                    'label' => 'email_new',
                ],
                'second_options' => [
                    'label' => 'email_new_repeat'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ChangeEmail::class);
    }
}
