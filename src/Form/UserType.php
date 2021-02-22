<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array(
                'label'=> "Entrez votre prénom"
            ))
            ->add('lastname', null, array(
                'label'=> "Entrez votre nom"
            ))
            ->add('username', null, array(
                'label'=> "Entrez votre pseudonyme"
            ))
            ->add('email', EmailType::class, array(
                'label' => 'E-mail',
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'Entrez votre mot de passe',
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
