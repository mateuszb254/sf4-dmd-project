<?php

namespace App\User\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangeCharRemovalCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class, [
                'label' => 'password'
            ])
            ->add('charRemovalCode', RepeatedType::class, [
                'type' => TextType::class,
                'first_options' => [
                    'label' => 'char_removal_code',
                ],
                'second_options' => [
                    'label' => 'char_removal_code_new_repeat'
                ]
            ]);
    }
}
