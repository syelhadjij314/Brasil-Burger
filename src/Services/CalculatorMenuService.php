<?php
namespace App\Services ;

use App\Entity\Menu;


class CalculatorMenuService{
    /**
     * @param Menu $data
     */
    public function priceMenu($data)
    {
        $prix=0;
        foreach ($data->getMenuBurgers() as $burger) {          
            $prix+=$burger->getBurger()->getPrix()*$burger->getQuantiteBurger();
        }

        foreach ($data->getMenuTailles() as $boisson) {
            $prix+=$boisson->getTaille()->getPrix()*$boisson->getQuantiteTailleBoisson();
        }

        foreach ($data->getMenuFrites() as $frite) {
            $prix+=$frite->getFrite()->getPrix()*$frite->getQuantiteFrite();
        }
        return $prix;
    }
}