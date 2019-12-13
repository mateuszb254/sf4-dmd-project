<?php

namespace App\Support\Form\Type;

use App\Support\Entity\TicketCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'support_ticket_title'
            ])
            ->add('category', EntityType::class, [
                'label' => 'support_ticket_category',
                'class' => TicketCategory::class
            ])
            ->add('content', TextareaType::class, [
                'label' => 'support_ticket_content'
            ]);
    }
}
