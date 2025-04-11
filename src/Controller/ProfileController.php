<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/profile')]
final class ProfileController extends AbstractController
{
    #[Route('', name: 'profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    // #[IsGranted("ROLE_USER")]
    #[Route('/edit', name: 'profile_edit')]
    public function profilShow(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        request $request,
        ): Response
    {
        // Si je ne suis pas connecté j'ai RIEN A FAIRE ICI
        
        $user = $this->getUser();

        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
            // do anything else you need here, like send an email

            // return $security->login($user, AppCustomAuthenticator::class, 'main');
        }

        return $this->render('profile/profile_edit.html.twig', [
            'form' => $form,
        ]);
    }
}
