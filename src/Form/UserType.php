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
                'label'=> "Prénom"
            ))
            ->add('lastname', null, array(
                'label'=> "Nom"
            ))
            ->add('username', null, array(
                'label'=> "Nom d'utilisateur"
            ))
            ->add('email', EmailType::class, array(
                'label' => 'E-mail',
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'Mot de passe',
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
