<?php

namespace App\Form;

use App\Entity\ContactDisplay;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactDisplayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label'=> "Nom d'utilisateur*",
                'label_attr' => array(
                    'class' => 'blue',
                ),
                'attr' => array(
                    'class' => 'form-control'
                    )
            ))
            ->add('email', TextType::class, array(
                'label'=> "Email*",
                'label_attr' => array(
                    'class' => 'blue',
                ),
                'attr' => array(
                    'class' => 'form-control'
                    )
            ))
            ->add('phone', TextType::class, array(
                'label'=> "Téléphone",
                'label_attr' => array(
                    'class' => 'blue',
                ),
                'attr' => array(
                    'class' => 'form-control'
                    )
            ))
            ->add('message', TextareaType::class, array(
                'label'=> "Votre message*",
                'label_attr' => array(
                    'class' => 'blue',
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'height: 100px',
                    )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactDisplay::class,
            'attr'=> array(
                'novalidate' => 'novalidate',
            ),
        ]);
    }
}
