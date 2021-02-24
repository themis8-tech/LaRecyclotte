<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array(
                'label'=> "Prénom"
            ))

            ->add('lastname', null, array(
                'label'=> "Nom"
            ))
            
            ->add('username', null, array(
                'label'=> "Nom d'utilisateur",
                'attr'=> array(
                    'placeholder'=> 'Choisissez un pseudonyme',
                    
                )
            ))
            ->add('email', EmailType::class, array(
                'label' => 'E-mail',
                
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'Mot de passe',
                'attr'=> array(
                    'placeholder'=> 'Minimum 8 caractères'
                )
            ))

            ->add('CGU', CheckboxType::class, array(
                'label' => "J'accepte les CGU",
                'required'=> false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver, )
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr'=> array(
                'novalidate' => 'novalidate',
            ), 
            'validation_groups' => ['Default', 'registration']
        ]);
    }
}
