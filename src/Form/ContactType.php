<?php

namespace App\Form;

use App\entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array(
            'label'=> "Nom*",
            'attr'=>array(
            'placeholder'=>'Entrez votre Nom'
            )
            ))
            ->add('phone',TelType::class,array(
                'label'=> "Téléphone",
                'attr'=>array(
                    'placeholder'=>'Entrez votre numéro de téléphone'
                )
            ))
            ->add('email',EmailType::class,array(
                'label'=> "Email*",
                'attr'=>array(
                    'placeholder'=>'Entrez votre Email'
                )
            ))
            ->add('message',TextareaType::class,array(
                'label'=> "Message*",
                'attr'=>array(
                    'placeholder'=>'Entrez votre message: minimum 30 caractères'
                )
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'attr'=> array(
                'novalidate' => 'novalidate',
            ),
        ]);
    }
}
