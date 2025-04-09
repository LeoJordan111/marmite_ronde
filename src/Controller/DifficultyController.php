<?php

namespace App\Controller;

use App\Entity\Difficulty;
use App\Form\DifficultyType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/difficulty')]
final class DifficultyController extends AbstractController
{
    #[Route('', name: 'difficulty')]
    public function index(): Response
    {
        return $this->render('difficulty/index.html.twig', [
            'controller_name' => 'DifficultyController',
        ]);
    }

    #[Route('/add', name: 'difficulty_add')]
    public function difficultyAdd(
        EntityManagerInterface $entityManager,
        request $request
    ): Response
    {

        $difficulty = new Difficulty();

        $form = $this->createForm(DifficultyType::class, $difficulty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($difficulty);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('difficulty/difficulty_add.html.twig', [
            'controller_name' => 'DifficultyController',
            'form' => $form->createView(),
        ]);
    }
}
