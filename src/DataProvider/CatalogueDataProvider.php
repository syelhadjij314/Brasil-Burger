<?php

namespace App\DataProvider;

use App\Entity\DTO\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\Burger;


class CatalogueDataProvider implements  RestrictedDataProviderInterface,ContextAwareCollectionDataProviderInterface
{
    public function __construct(MenuRepository $menuRepository, BurgerRepository $burgerRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->burgerRepository = $burgerRepository;
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool
    {
        return $resourceClass == Catalogue::class or $resourceClass == Burger::class;
    }
    
    public function getCollection(string $resourceClass, ?string $operationName = null, array $context = [])
    {

        if ($resourceClass == Catalogue::class) {
            // dd();
            return [

                ['menus' => $this->menuRepository->findAll()],
                ['burgers' => $this->burgerRepository->findAll()]

            ];
        }
        
    }
   /*  public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $catalogue= new Catalogue;
        // dd($catalogue);
        $menu = $this->menuRepository->findBy(["isEtat"=>true],["id"=>"DESC"]) ;
        // dd($menu);
        $burger = $this->burgerRepository->findBy(["isEtat"=>true],["id"=>"DESC"]) ;
        // dump($burger);
        // dd("ok");

        $catalogue -> setMenus($menu);
        $catalogue -> setBurgers($burger);
// dd($catalogue);
        return $catalogue;
    } */
    
    
}