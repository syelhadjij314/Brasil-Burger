<?php
namespace App\DataProvider;

use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\DTO\Detail;
use App\Repository\BoissonRepository;
use App\Repository\FriteRepository;

class DetailDataProvider implements RestrictedDataProviderInterface,ItemDataProviderInterface {

    public function __construct(
        MenuRepository $menuRepository,
        BurgerRepository $burgerRepository,
        BoissonRepository $boissonRepository,
        FriteRepository $friteRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->burgerRepository = $burgerRepository;
        $this->boissonRepository = $boissonRepository;
        $this->friteRepository = $friteRepository;

    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool
    {
        return $resourceClass == Detail::class;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Detail
    {
        $detail= new Detail();
        $menu = $this->menuRepository->findOneBy(["id"=> $id, "isEtat"=>true]) ;
        // dd($menu);
        $burger = $this->burgerRepository->findOneBy(["id"=> $id, "isEtat"=>true]);


        $boisson = $this->boissonRepository->findBy(["isEtat"=> true]);
        $frite = $this->friteRepository->findBy(["isEtat"=> true]);

        $detail -> id = $id; // si l'attribut est public
        if ($burger==null) {
            $detail -> setProduit($menu);
        }
        if ($menu==null) {
            $detail -> setProduit($burger);
        }
       
       
        $detail -> setBoissons($boisson);
        $detail -> setFrites($frite);

        // dd($detail);
        return $detail;
    }
}