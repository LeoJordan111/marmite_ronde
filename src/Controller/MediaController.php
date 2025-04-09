<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\RecipeType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/media')]
final class MediaController extends AbstractController
{
    #[Route('', name: 'media')]
    public function index(): Response
    {
        return $this->render('media/index.html.twig', [
            'controller_name' => 'MediaController',
        ]);
    }

    #[Route('/add', name: 'media_add')]
    public function mediaAdd(
        EntityManagerInterface $entityManager,
        request $request
    ): Response
    {

        $media = new Media();

        $form = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($media);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('ingredient/ingredient_add.html.twig', [
            'controller_name' => 'IngredientController',
            'form' => $form->createView(),
        ]);
    }
}
