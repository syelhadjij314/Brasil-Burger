<?php

namespace App\DataProvider;

use App\Entity\Complement;
use App\Repository\FriteRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Repository\BoissonRepository;

class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(FriteRepository $friteRepository, BoissonRepository $boissonRepository)
    {
        $this->friteRepository = $friteRepository;
        $this->boissonRepository = $boissonRepository;
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool
    {
        return $resourceClass == Complement::class;

    }

    public function getCollection(string $resourceClass, ?string $operationName = null, array $context = [])
    {

        if ($resourceClass == Complement::class) {
            return [

                ['frites' => $this->friteRepository->findAll()],
                ['boissons' => $this->boissonRepository->findAll()]

            ];
        }
    }
}
