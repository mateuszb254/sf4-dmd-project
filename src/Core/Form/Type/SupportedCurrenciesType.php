<?php

namespace App\Core\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportedCurrenciesType extends AbstractType
{
    protected $currencies;

    public function __construct(array $currencies)
    {
        $this->currencies = $currencies;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'currency',
            'choices' => $this->prepareChoices()
        ]);
    }

    protected function prepareChoices(): array
    {
        return array_unique(
            array_combine($this->currencies, $this->currencies)
        );
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
