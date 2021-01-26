<?php

namespace App\Controller;

use App\Entity\RealEstate;
use App\Services\SuperCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add(RealEstate $realEstate, SuperCart $superCart): Response
    {
        // Avant d'ajouter au panier, on va vérifier si l'annonce est toujours en vente ou si l'annonce n'est pas déjà dans le panier
        if ($realEstate->getSold()) {
            $this->addFlash('danger', 'Trop tard, l\'annonce est vendue');
        } else if ($superCart->hasItem($realEstate->getId())) {
            $this->addFlash('danger', 'Vous avez déjà choisi cette annonce');
        } else {
            // Ajouter l'annonce dans la session
            $superCart->addItem($realEstate);
        }

        // Rediriger vers la page de l'annonce
        return $this->redirectToRoute('real_estate_show', [
            'id' => $realEstate->getId(),
            'slug' => $realEstate->getSlug(),
        ]);
    }

    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(SuperCart $superCart)
    {
        return $this->render('cart/index.html.twig', [
            'items' => $superCart->getItems(),
        ]);
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove(SuperCart $superCart, RealEstate $realEstate)
    {
        // on supprime le produit du panier
        $superCart->removeItem($realEstate->getId());

        return $this->redirectToRoute('cart_index');
    }
}
