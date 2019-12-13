<?php

namespace App\User\Form\Type;

use App\User\Entity\RoleGroup;
use App\User\Permissions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'user_role_group_name'
            ])
            ->add('permissions', ChoiceType::class, [
                'expanded' => true,
                'multiple' => true,
                'label' => 'permissions',
                'choices' => [
                    'articles' => [
                        'browse' => Permissions::ARTICLE_CAN_BROWSE_SECTION,
                        'add' => Permissions::ARTICLE_CAN_ADD,
                        'edit' => Permissions::ARTICLE_CAN_EDIT,
                        'delete' => Permissions::ARTICLE_CAN_DELETE,
                    ],
                    'users' => [
                        'browse' => Permissions::USER_CAN_BROWSE_SECTION,
                        'edit' => Permissions::USER_CAN_EDIT_USER,
                        'ban' => Permissions::USER_CAN_BAN_USER,
                        'delete' => Permissions::USER_CAN_DELETE_USER,
                    ],
                    'promotion_codes' => [
                        'browse' => Permissions::PROMOTION_COUPON_CAN_BROWSE,
                        'add' => Permissions::PROMOTION_CAN_ADD,
                        'edit' => Permissions::PROMOTION_CAN_EDIT,
                        'delete' => Permissions::PROMOTION_CAN_DELETE,
                        'generate' => Permissions::PROMOTION_COUPON_CAN_GENERATE,
                        'delete_coupon' => Permissions::PROMOTION_COUPON_CAN_GENERATE,
                    ],
                    'support' => [
                        'browse' => Permissions::SUPPORT_CAN_BROWSE_SECTION,
                        'close_ticket' => Permissions::SUPPORT_CAN_CLOSE_TICKET
                    ]
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RoleGroup::class
        ]);
    }
}
