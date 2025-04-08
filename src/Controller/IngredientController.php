<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/ingredient')]
final class IngredientController extends AbstractController
{
    #[Route('/show', name: 'ingredient_show')]
    public function ingredientShow(): Response
    {
        return $this->render('ingredient/ingredient_show.html.twig', [
            'controller_name' => 'IngredientController',
        ]);
    }

    #[Route('/add', name: 'ingredient_add')]
    public function ingredientAdd(
        EntityManagerInterface $entityManager,
        request $request
    ): Response
    {

        $ingredient = new Ingredient();

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ingredient);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('ingredient/ingredient_add.html.twig', [
            'controller_name' => 'IngredientController',
            'form' => $form->createView(),
        ]);
    }
}
