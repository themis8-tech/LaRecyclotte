<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RadioType;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Nom',
                'attr'=>array(
                'class'=> 'form-control',
                )
            ))
            ->add('etat', null, array(
                'label' => 'Etat',
                'attr'=>array(
                'class'=> 'form-control'
                )
            ))
            ->add('picture')
            ->add('description', null, array(
                'label' => "Déscription de l'objer",
                'attr' => array(
                'class' => 'form-control', 
                ),
                
            ))
            ->add('category', null, array(
                'label' => 'Catégorie',
                'choice_label' => 'name',
                'expanded' => 'true',
                'attr' => array(
                'class' => 'form'
                )
            ))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
