<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
// use Symfony\  serializerinterface
// use     groups à chercher sur la doc

#[Route('/api')]
final class ApiController extends AbstractController
{
    #[Route('', name: 'api')]
    public function index(): Response
    {
        return new JsonReponse("coocou API !!");

    }

    #[Route('/{id}', name: 'api')]
    public function show(
        Recipe $recipe,
        serializerInterface $serializer,
    ): Response
    {
        // aller sur l'entité(s) voulu(s) et la configurer pour du JSON
        // $recipejson = $serializer->serialize($recipe, "json", ['group' => 'recipe_read']);

        return new JsonReponse(
            $recipejson,
            200,
            [],
            true,
    );

    }

    #[Route('/exemple', name: 'exemple')]
    public function example(
        Cat $cat
    ): Response
    {

        return new JsonReponse(
            $cat, //data (juste cette ligne est suffissante les autres paras sont par défaut)
            200, // code à renvoyer
            [], // Rien à ajouter
            false // lui dire si la data est du JSON ou non
    );

    }
}
