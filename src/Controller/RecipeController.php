<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Comment;
use App\Form\RecipeType;
use App\Form\CommentType;
use App\Repository\UserRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/recipe')]
final class RecipeController extends AbstractController
{
    #[Route('', name: 'recipe')]
    public function index(): Response
    {
        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }

    #[Route('/add/{id}', name: 'recipe_add')]
    public function recipeAdd(
        int $id,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        request $request,
    ): Response
    {

        $user = $userRepository->find($id);

        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setUser($this->getUser());
            $entityManager->persist($recipe);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('recipe/recipe_add.html.twig', [
            'controller_name' => 'RecipeController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/show/{id}', name: 'recipe_show')]
    public function recipeShow(
        int $id,
        RecipeRepository $recipeRepository,
        EntityManagerInterface $entityManager,
        request $request
    ): Response
    {

        $recipe = $recipeRepository->find($id);

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('recipe/recipe_show.html.twig', [
            'controller_name' => 'RecipeController',
            'form' => $form->createView(),
            'recipe' => $recipe,
        ]);
    }
}
