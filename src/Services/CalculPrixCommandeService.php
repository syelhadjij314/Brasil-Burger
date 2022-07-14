<?php
namespace App\Services;

class CalculPrixCommandeService{

    public function montantCommande($data){
        $prix=0;
        foreach ($data->getCommandeBoissons() as $boisson) {
            $prix+=$boisson->getBoisson()->getPrix()*$boisson->getQuantite();
            $boisson->setPrix($boisson->getBoisson()->getPrix());
        }
        foreach ($data->getCommandeBurgers() as $burger) {
            $prix+=$burger->getBurger()->getPrix()*$burger->getQuantite();
            $burger->setPrix($burger->getBurger()->getPrix());
        }
        foreach ($data->getCommandeFrites() as $frite) {
            $prix+=$frite->getFrite()->getPrix()*$frite->getQuantite();
            $frite->setPrix($frite->getFrite()->getPrix());
        }
        foreach ($data->getCommandeMenus() as $menu) {
            $prix+=$menu->getMenu()->getPrix()*$menu->getQuantite();
            $menu->setPrix($menu->getMenu()->getPrix());
        }
        $montant=$prix+$data->getZone()->getPrix();
        $data->setMontant($montant);
    }
}
