<?php

namespace App\Core\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Enables to check if an user is allowed to edit the specific field
 *
 * Available options:
 *      'is_granted' represents role name
 *      'is_granted_hide' if set to true the field will be removed otherwise it will be just disabled
 */
class IsGrantedExtension extends AbstractTypeExtension
{
    /** @var AuthorizationCheckerInterface */
    protected $authorizationChecker;

    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$options['is_granted']) {
            return;
        }

        if ($options['is_granted_hide']) {
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
                if ($this->isGranted($options)) {
                    return;
                }

                $form = $event->getForm();
                $parent = $form->getParent();

                $parent->remove($form->getName());
            });

            return;
        }

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
            if ($this->isGranted($options)) {
                return;
            }

            $event->setData($event->getForm()->getViewData());
        });
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($this->isGranted($options)) {
            return;
        }

        $this->disableView($view);
    }

    protected function disableView(FormView $view)
    {
        $view->vars['attr']['disabled'] = true;

        foreach ($view as $child) {
            $this->disableView($child);
        }
    }

    protected function isGranted(array $options)
    {
        if (!$options['is_granted']) {
            return true;
        }

        return $this->authorizationChecker->isGranted($options['is_granted']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'is_granted' => null,
            'is_granted_hide' => false,
        ]);

        $resolver->setRequired('is_granted');
        $resolver->setAllowedTypes('is_granted_hide', 'boolean');
    }

    public function getExtendedTypes()
    {
        return [FormType::class];
    }
}
