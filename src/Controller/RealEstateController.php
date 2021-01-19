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
        $sizes = [
            1 => 'Studio',
            2 => 'T2',
            3 => 'T3',
            4 => 'T4',
            5 => 'T5'
        ];
        // On appelle le dépôt d'une entité (là où sont stockées les entités)
        $repository = $this->getDoctrine()->getRepository(RealEstate::class);
        // Équivaut à SELECT * FROM real_estate
        $properties = $repository->findAll();

        return $this->render('real_estate/index.html.twig', [
            'sizes' => $sizes,
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/nos-biens/{id}", name="real_estate_show")
     *
     * URL de la page qui affiche un bien
     */
    public function show(RealEstate $property) //ainsi symfony gère la BDD et la page 404
    {
        // Avec @ParamConverter, on n'a pas besoin du code suivant
        // Il suffit de typer le paramètre avec l'entité que l'on souhaite récupérer

        // Si show($id), on récupère la propriété en BDD
        // $property = $this->getDoctrine()->getRepository(RealEstate::class)
        //   ->find($id);

        // Renvoie une 404 si la propriété n'existe pas
        // if (!$property) {
        //    throw $this->createNotFoundException();
        // }

        return $this->render('real_estate/show.html.twig', [
            'property' => $property,
            'title' => $property->getTitle(),
        ]); //chemin vers le fichier
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

            // Faire une redirection après l'ajout et afficher un message de succès
            $this->addFlash('success', 'Votre annonce '.$realEstate->getId().' a bien été créée');

            //Faire redirection vers la liste des annonces
            return $this->redirectToRoute("real_estate_list");
            //Afficher le msg flash dans le html

        }

        return $this->render('real_estate/create.html.twig', [
            //Pour afficher le formulaire
            'realEstateForm' => $form->createView(),
        ]);

    }
}
