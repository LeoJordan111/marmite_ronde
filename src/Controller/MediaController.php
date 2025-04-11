<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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

    #[Route('/add/{idrecipe}', name: 'media_add')]
    public function mediaAdd(
        int $idrecipe,
        RecipeRepository $recipeRepository,
        EntityManagerInterface $entityManager,
        request $request,
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/uploads/images')] string $imagesDirectory
    ): Response
    {
        $recipe = $recipeRepository->find($idrecipe);

        $media = new Media();

        $form = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $imageFile = $form->get('path')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move($imagesDirectory, $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $media->setPath($newFilename);
            }
            $media->setRecipe($recipe);
            $entityManager->persist($media);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('media/media_add.html.twig', [
            'controller_name' => 'MediaController',
            'form' => $form->createView(),
            'recipe' => $recipe
        ]);
    }

    #[Route('/edit/{idrecipe}/{idmedia}', name: 'media_edit')]
    public function mediaEdit(
        int $idrecipe,
        int $idmedia,
        MediaRepository $mediaRepository,
        EntityManagerInterface $entityManager,
        request $request,
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/uploads/images')] string $imagesDirectory
    ): Response
    {
        $media = $mediaRepository->findOneBy([
            'recipe' => $idrecipe,
            'id' => $idmedia,
        ]);

        $form = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $imageFile = $form->get('path')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move($imagesDirectory, $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $media->setPath($newFilename);
            }

            $entityManager->persist($media);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('media/media_edit.html.twig', [
            'controller_name' => 'MediaController',
            'form' => $form->createView(),
            'media' => $media
        ]);
    }

    #[Route('/remove/{idrecipe}/{idmedia}', name: 'media_remove')]
    public function mediaReomve(
        int $idrecipe,
        int $idmedia,
        MediaRepository $mediaRepository,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $media = $mediaRepository->findOneBy([
            'recipe' => $idrecipe,
            'id' => $idmedia,
        ]);
        // dd($media);

        $entityManager->remove($media);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    #[Route('/showbyrecipe/{idrecipe}', name: 'media_showbyrecipe')]
    public function recipeShowbyrecipe(
        int $idrecipe,
        MediaRepository $mediaRepository,
        EntityManagerInterface $entityManager,
        request $request
    ): Response
    {
       $media = $mediaRepository->findBy([
            'recipe' => $idrecipe,
        ]);
        
        // dd($idrecipe);

        return $this->render('media/media_showbyrecipe.html.twig', [
            'controller_name' => 'RecipeController',
            'media' => $media,
        ]);
    }
}
