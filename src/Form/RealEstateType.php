<?php

namespace App\Form;

use App\Entity\RealEstate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RealEstateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('price')
            ->add('rooms')
            ->add('type')
            ->add('sold')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // App\Entity\RealEstate = RealEstate::class
            'data_class' => RealEstate::class,
        ]);
    }
}
