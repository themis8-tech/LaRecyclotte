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
                  'class' => 'form-control'
                  ) 
                  ))

            ->add('picture', FileType::Class, array( 
                    'label'=> "Photo de l'objet*",
                    'attr' => array(
                    'class' => 'form-control'
                    )
                    ))

            ->add('city', null, array(
                'label' => "Ville*",
                'attr' => array(
                'placeholder' => 'Ex: Lille',
                 'class' => 'form-control'
                )
                ))

            ->add('description', null, array(
                'label' => "Déscription*",
                'attr' => array(
                    'rows'=>7,
                'placeholder' => 'Couleur, dimension, matériaux...',
                 'class' => 'form-control'
                )
                ))

            ->add('category', null , array(
                'label' => "Categories*",
                'placeholder' => '---Choisissez sa catégorie---',
                'choice_label' => 'name',
                'attr' => array(
                'class' => 'form-control'
                )
                ))

            ->add('user', null, array(
                'label' => "Utilisateur",
                'choice_label' => 'username',
                'attr' => array(
                'class' => 'form-control'
                )
                ))

            ->add('zipcode', null, array(
                'label' => "Code Postale*",
                'placeholder' => '---Choisissez le lieu de retrait---',
                'choice_label' => 'code',
                'attr' => array(
                'class' => 'form-control'
                )
                ))
            ->add('state', null, array(
                'label' => "Etat de l'objet*",
                'placeholder' => '---Choisissez son état---',
                'choice_label' => 'name',
                'attr' => array(
                    'class' => 'form-control'
                )
                ))

            ->add('endAt', null, array(
                'label' => "Date d'expiration*",
                
                'attr' => array(
                'placelholder'=>'Date', 
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
