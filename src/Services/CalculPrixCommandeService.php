<?php
namespace App\Services;

class CalculPrixCommandeService{

    public function montantCommande($data){
        // $prix=0;
        foreach ($data->getProduitCommandes() as $produit) {
            $prix=$produit->getProduit()->getPrix()*$produit->getQuantite();
            $produit->setPrix($prix);
        }
        // return $prix;
    }
}
