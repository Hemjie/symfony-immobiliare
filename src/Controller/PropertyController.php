<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    // Pour partager le tableau dans toute la classe
    private $properties = [
        [ 'title' => 'Maison avec piscine'],
        [ 'title' => 'Appartement avec terrasse'],
        [ 'title' => 'Studio centre ville']
    ];

    /**
     * @Route("/property/{page}", name="property_list", requirements={"page"="\d+"})
     *
     * Page qui liste les annonces immobilières
     * requirement permet de vérifier que page est un nombre avec une regex
     * si ce n'est pas un nombre, il fera la fonction show
     */
    public function index($page = 1): Response //fixer la valeur par défaut éviter les erreurs
    {
        //Pour démarrer, on va créer un tableau d'annonces
        $properties = $this->properties;

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
        // Ici, on peut vérifier que le slug soit dans notre tableau properties
        if(!in_array($slug, array_column($this->properties, 'title'))) {
            // permet de lever une exception, on arrête le code et on renvoie une erreur.
            //symfony fera un try catch et renverra une 404
            throw $this->createNotFoundException('Annonce non existante');
        }

        return $this->render('property/show.html.twig', [
            'slug' => $slug,
        ]);
    }

    /**
     * @Route("/property.json", name="property_api")
     */
    public function api(): Response
    {
        return $this->json($this->properties);
    }
}
