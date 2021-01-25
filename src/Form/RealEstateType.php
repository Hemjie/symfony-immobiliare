<?php

namespace App\Form;

use App\Entity\RealEstate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RealEstateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface', RangeType::class, [  //on configure un input de type range
                'attr' => [
                    'min' => 10,
                    'max' => 400,
                    'class' => 'p-0',
                ],
            ])
            ->add('price', null, [
                'label' => 'Prix',
            ])
            ->add('rooms', ChoiceType::class, [
                'choices' => [
                    // 'Affiche' => 'Value'  Attention, inverse du formulaire en HTML
                    'Studio' => 1,
                    'T2' => 2,
                    'T3' => 3,
                    'T4' => 4,
                    'T5' => 5,
                ],
                'label' => 'Nombre de pièces'
            ])
            ->add('type', null, [
                'choice_label' => 'name', //On affiche la valeur de la propriété name des objets Type
                'expanded' => true,       // On met des input radio
            ])
            ->add('sold', ChoiceType::class, [
                'label' => 'Vendu?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ]
            ])
            ->add('image', FileType::class, [
                //On désactive le lien avec la BDD pour l'image car Symfony ne sait pas l'afficher
                'mapped' => false,
            ])
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
