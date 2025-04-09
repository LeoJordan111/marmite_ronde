<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre de votre image :",
                'required' => true,
            ])
            ->add('path', FileType::class, [
                'label' => "Fichier de l'image :",
                'required' => false,
                'mapped' => false,
            ])
            ->add('recipe', EntityType::class, [
                'class' => Recipe::class,
                'choice_label' => 'title',
            ])
            ->add('ingredient', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
