<?php

namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class DataProviderCatalogue implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(MenuRepository $menuRepository, BurgerRepository $burgerRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->burgerRepository = $burgerRepository;
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool
    {
        return $resourceClass == Catalogue::class;
    }

    public function getCollection(string $resourceClass, ?string $operationName = null, array $context = [])
    {

        if ($resourceClass == Catalogue::class) {
            return [

                ['menus' => $this->menuRepository->findAll()],
                ['burgers' => $this->burgerRepository->findAll()]

            ];
        }

    }
}