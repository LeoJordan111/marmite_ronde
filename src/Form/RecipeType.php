<?php

namespace App\Form;

use App\Entity\Like;
use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Difficulty;
use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre de votre recette :",
                'required' => true,
            ])
            // ->add('createdAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updateAt', null, [
            //     'widget' => 'single_text',
            // ])
            ->add('duration', NumberType::class, [
                'label' => 'Durée de la recette :',
            ])
            ->add('numberPers', NumberType::class, [
                'label' => 'Nombre de personne :',
            ])
            ->add('content', TextareaType::class, [
                'label' => "Titre de votre recette :",
                'required' => true,
            ])
            ->add('ingredient', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'label',
                'expanded' => true,
                'multiple' => true,
            ])
            // ->add('likeIs', EntityType::class, [
            //     'class' => Like::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
            ->add('difficulty', EntityType::class, [
                'label' => 'Difficulté de la recette :',
                'class' => Difficulty::class,
                'choice_label' => 'label',
            ])
            // le gérer en récupérant l'id de la personne connectée
            // ->add('user', EntityType::class, [
            //     'label' => 'Auteur de la recette :',
            //     'class' => User::class,
            //     'choice_label' => 'firstname',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
