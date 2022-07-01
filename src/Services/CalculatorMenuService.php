<?php
namespace App\Services ;

class CalculatorMenuService{
    public function priceMenu($data)
    {
        $prix=0;
        foreach ($data->getBurgers() as $burger) {
            
            $prix+=$burger->getPrix();

        }
        foreach ($data->getBoissons() as $boisson) {
            // dd("ok1");

            $prix+=$boisson->getPrix();
        }
        foreach ($data->getFrites() as $frite) {
            // dd("ok3");

            $prix+=$frite->getPrix();
        }
        return $prix;
    }
}