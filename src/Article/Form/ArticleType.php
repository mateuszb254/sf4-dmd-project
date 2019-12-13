<?php

namespace App\Article\Form;

use App\Article\Entity\Article;
use App\User\Permissions;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
            'label' => 'title'
        ])->add('contents', CKEditorType::class, [
            'label' => 'contents'
        ])->add('status', ChoiceType::class, [
            'choices' => [
                'published' => Article::STATUS_PUBLISHED,
                'draft' => Article::STATUS_DRAFT
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'is_granted' => Permissions::ARTICLE_CAN_EDIT
        ]);
    }
}
