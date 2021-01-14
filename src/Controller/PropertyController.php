<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/property", name="property")
     *
     * Page qui liste les annonces immobilières
     */
    public function index(): Response
    {
        //Pour démarrer, on va créer un tableau d'annonces
        $properties = [
            [ 'title' => 'Maison avec piscine'],
            [ 'title' => 'Appartement avec terrasse'],
            [ 'title' => 'Studio centre ville']
        ];

        //Equivalent du var_dump
        dump($properties);

        return $this->render('property/index.html.twig', [
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("property/{slug}", name="property_show")
     *
     * Page qui affiche une annonce avec un paramètre dynamique (ici slug)
     */
    public function show($slug): Response
    {
        return $this->render('property/show.html.twig', [
            'slug' => $slug,
        ]);
    }
}
