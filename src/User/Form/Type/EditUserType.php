<?php

namespace App\User\Form\Type;

use App\User\Entity\RoleGroup;
use App\User\Entity\User;
use App\User\Model\UserInterface;
use App\User\Permissions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', TextType::class, [
            'label' => 'login'
        ])->add('email', EmailType::class, [
            'label' => 'email'
        ])->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => false,
            'first_options' => ['label' => 'password',],
            'second_options' => ['label' => 'password_repeat']
        ])->add('charRemovalCode', TextType::class, [
            'label' => 'char_removal_code'
        ])->add('securityQuestion', TextType::class, [
            'label' => 'security_question',
        ])->add('securityAnswer', TextType::class, [
            'label' => 'security_answer'
        ])->add('coins', NumberType::class, [
            'label' => 'user_coins',
        ])->add('roleGroup', EntityType::class, [
            'label' => 'user_role_group',
            'class' => RoleGroup::class,
            'placeholder' => 'user_role_group_none',
            'required' => false,
            'is_granted' => UserInterface::ROLE_GLOBAL_ADMIN,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_granted' => Permissions::USER_CAN_EDIT_USER
        ]);
    }
}
