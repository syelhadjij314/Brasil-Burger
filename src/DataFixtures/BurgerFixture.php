<?php
namespace App\DataFixtures;

use App\Entity\Burger;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class BurgerFixture extends Fixture{

    public function load(ObjectManager $manager):void{
        
        $noms=["Burger Simple","Burger Viande Poulet","Burger Plus","Burger Royale Plus","Burger Viande Mouton","Burger Complet","Burger Chicago","Burger Royale Simple"];
        $prix=[1500,2000,2500,2000,3000,3500,2000,1500,2500];
        for ($i = 1; $i <= 10; $i++) 
        {
            $pos = rand(0, 2);
            $burger = new Burger();
            $burger->setNom($noms[$pos]);
            $burger->setPrix($prix[$pos]);
            $manager->persist($burger);
            $this->addReference("Burger" . $i, $burger);
        }

        $manager->flush();
    }

}