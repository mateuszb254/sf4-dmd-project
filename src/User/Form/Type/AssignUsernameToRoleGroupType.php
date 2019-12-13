<?php

namespace App\User\Form\Type;

use App\User\Entity\RoleGroup;
use App\User\Form\Transformer\UserToLoginTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AssignUsernameToRoleGroupType extends AbstractType
{
    protected $userTransformer;

    public function __construct(UserToLoginTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', TextType::class, [
                'label' => 'login'
            ])
            ->add('roleGroup', EntityType::class, [
                'label' => 'user_role_group',
                'class' => RoleGroup::class
            ]);

        $builder->get('user')->addModelTransformer($this->userTransformer);
    }
}
