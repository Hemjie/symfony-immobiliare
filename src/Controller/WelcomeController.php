<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController //permet d'utiliser le render
{
    /**
     * @Route("/hello", name="hello")
     */
    //name sert à renommer la route
    // "/hello" pour l'url
    public function hello() : Response { // : Response permet typage de la fonction
        //bien mettre le code pour une route juste en-dessous
        // on renvoie tjs un objet Response
        // return new Response('<html><body>Hello Symfony</body></html>'); //balise body pour que la toolbar fonctionne tjs

        $name = "Symfony";
        //le chemin templates est déjà dans le render, retourne tjs une réponse
        //le second paramètre de render est un tableau avec clé => valeur
        //où clé est le nom de la variable Twig et valeur, celle de la variable
        return $this->render('welcome/hello.html.twig',
            ['name' => $name
            ]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function home(): Response
    {
        return $this->render('welcome/home.html.twig');
    }
}