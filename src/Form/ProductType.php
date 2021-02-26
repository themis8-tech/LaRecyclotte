<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                 'label'=> "Titre*",
                  'attr' =>array(
                  'Placeholder'=>'Ex: Fauteuil',
                  ) 
                  ))

            ->add('picture', FileType::class, array( 
                    'label'=> "Photo de l'objet*",
                    'attr' => array(
                    'class'=>'form-control'
                    )
                    ))

            ->add('city', null, array(
                'label' => "Ville*",
                'attr' => array(
                'placeholder' => 'Ex: Lille',
                )
                ))

            ->add('description', null, array(
                'label' => "Déscription",
                'attr' => array(
                'rows'=>5,
                'placeholder' => 'Couleur, dimension, matériaux...',
                )
                ))

            ->add('category', null , array(
                'label' => "Categories*",
                'placeholder' => '---Choisissez sa catégorie---',
                'choice_label' => 'name',
                ))

            ->add('zipcode', null, array(
                'label' => "Code Postale*",
                'placeholder' => '---Choisissez le lieu de retrait---',
                'choice_label' => 'code',
                'attr' => array(
                )
                ))
                
            ->add('state', null, array(
                'label' => "Etat de l'objet*",
                'placeholder' => '---Choisissez son état---',
                'choice_label' => 'name',
                ))

            ->add('endAt', null, array(
                'label' => "Disponible jusqu'au ? *",
                'attr' => array(
                'placelholder'=>'Date',
                'class' => 'd-flex' 
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
