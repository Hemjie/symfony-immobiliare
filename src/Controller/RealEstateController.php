<?php

namespace App\Controller;

use App\Entity\RealEstate;
use App\Form\RealEstateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RealEstateController extends AbstractController
{
    /**
     * @Route("/nos-biens", name="real_estate_list")
     *
     * La page qui affiche la liste des biens
     */
    public function index(): Response
    {
        return $this->render('real_estate/index.html.twig');
    }

    /**
     * @Route("/creer_un_bien", name="real_estate_create")
     */
    public function create(Request $request): Response
    {
        // Avec Symfony, on peut créer un formulaire
        // Le formulaire est tjs dans une classe à part
        // Dans la plupart des cas, on passe une entité à un formulaire
        $realEstate = new RealEstate(); //use App\Entity\RealEstate;
        $form = $this->createForm(RealEstateType::class, $realEstate);

        //Il faut lier le formulaire à la requête (pour récupérer $_POST)
        $form->handleRequest($request);

        // On doit vérifier que le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Ici, on ajoute l'annonce dans la base...
            //$realEstate = $form->getData() : pour récupérer les données du formulaire
            dump($realEstate);

            //Je dois ajouter l'objet dans la BDD
            $entityManager = $this->getDoctrine()->getManager();
            //Je dois mettre l'objet en attente
            $entityManager->persist($realEstate);
            //Exécuter la requête
            $entityManager->flush();
        }

        return $this->render('real_estate/create.html.twig', [
            //Pour afficher le formulaire
            'realEstateForm' => $form->createView(),
        ]);

    }
}
