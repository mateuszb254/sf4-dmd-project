<?php

namespace App\User\Form\Type;

use App\Core\Form\Type\RecaptchaType;
use App\User\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', TextType::class, [
            'label' => 'login'
        ])->add('email', EmailType::class, [
            'help' => 'registration_email_help',
            'label' => 'email'
        ])->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'password',
                'help' => 'registration_password_help',
            ],
            'second_options' => [
                'label' => 'password_repeat'
            ]
        ])->add('charRemovalCode', TextType::class, [
            'label' => 'char_removal_code'
        ])->add('securityQuestion', TextType::class, [
            'label' => 'security_question',
            'help' => 'registration_security_question_help'
        ])->add('securityAnswer', TextType::class, [
            'label' => 'security_answer'
        ])->add('terms', CheckboxType::class, [
            'label' => 'terms_accept_info',
            'mapped' => false,
            'constraints' => [
                new IsTrue()
            ]
        ])->add('recaptcha', RecaptchaType::class);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', User::class);
    }
}
