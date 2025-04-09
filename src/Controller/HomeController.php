<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\RecipeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class HomeController extends AbstractController
{
    #[Route('', name: 'home')]
    public function index(
        RecipeRepository $recipeRepository
    ): Response
    {

        $recipes = $recipeRepository->findAll();
        // dd($recipes);

        return $this->render('home/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }
}
