<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                 'label'=> "Nom de l'objet",
                  'attr' =>array(
                  'class' => 'form-control'
                  ) 
                  ))

            ->add('picture', FileType::Class, array( 
                    'label'=> "Photo de l'objet",
                    'attr' => array(
                    'class' => 'form-control'
                    )
                    ))
                    
            ->add('createdAt')
            ->add('city')
            ->add('description')
            ->add('visible')
            ->add('category')
            ->add('user')
            ->add('zipcode')
            ->add('state')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
