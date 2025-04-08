<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => "Votre email :",
                'required' => true,
            ])
            // ->add('roles')
            // ->add('password')
            ->add('firstname', TextType::class, [
                'label' => "Votre prénom :",
                'required' => true,
            ])
            ->add('lastname', TextType::class, [
                'label' => "Votre nom :",
                'required' => true,
            ])
            ->add('birthedAt', null, [
                'label' => "Votre date de naissance :",
                'widget' => 'single_text',
            ])
            // ->add('avatar')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
