<?php

namespace App\Controller;

use App\Entity\RealEstate;
use App\Services\SuperCart;
use Stripe\PaymentIntent;
use Stripe\Stripe;
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
    public function index(SuperCart $superCart, $stripeKey)
    {
        Stripe::setApiKey($stripeKey);

        // Vérification non cohérente dans la réalité, Stripe n'autorise que les paiements inférieurs à 1 million
        $total = $superCart->total();
        if($total >= 999999) {
            $total = 999999;
        }

        // Attention, il faut vérifier que le panier soit rempli avant de faire le paiement
        $clientSecret = null;
        if ($total > 0) {
            //on va créer l'intention de paiement
            $paymentIntent = PaymentIntent::create([
                'amount' => $total * 100, //10.99 devient 1099
                'currency' => 'eur',
            ]);
            $clientSecret = $paymentIntent->client_secret;
        }

        return $this->render('cart/index.html.twig', [
            'items' => $superCart->getItems(),
            //ON passe le secret dans la vue pour effectuer le paiement plus tard
            'clientSecret' => $clientSecret,
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

    /**
     * @Route("/cart/success/{id}", name="cart_success")
     */
    public function success($id, $stripeKey, SuperCart $superCart)
    {
        Stripe::setApiKey($stripeKey);
        //On peut retrouver les infos du paiement dans Stripe
        $paymentIntent = PaymentIntent::retrieve($id);

        //Envoyer le mail...


        return $this->render('cart/success.html.twig');
    }
}
