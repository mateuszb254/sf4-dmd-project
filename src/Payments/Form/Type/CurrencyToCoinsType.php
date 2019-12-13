<?php

namespace App\Payments\Form\Type;

use App\Core\Form\Type\SupportedCurrenciesType;
use App\Payments\Form\Model\CurrencyToCoins;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CurrencyToCoinsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('amount', NumberType::class, [
            'label' => 'currency_amount',
            'help' => 'currency_amount_help'
        ])->add('currency', SupportedCurrenciesType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CurrencyToCoins::class
        ]);
    }
}
