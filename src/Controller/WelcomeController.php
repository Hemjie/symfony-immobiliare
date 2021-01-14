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
    public function hello() { //bien mettre le code pour une route juste en-dessous
        // on renvoie tjs un objet Response
        // return new Response('<html><body>Hello Symfony</body></html>'); //balise body pour que la toolbar fonctionne tjs
        return $this->render('Welcome/hello.html.twig'); //le chemin templates est déjà dans le render
    }
}