<?php

namespace App\User\Form\Type;

use App\Core\Form\Type\RecaptchaType;
use App\User\Form\Model\PasswordResetRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestPasswordResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'email'
            ])
            ->add('recaptcha', RecaptchaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', PasswordResetRequest::class);
    }
}
