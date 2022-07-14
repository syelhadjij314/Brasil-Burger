<?php
namespace App\DataPersister;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\CalculPrixCommandeService;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class CommandeDataPersister implements ContextAwareDataPersisterInterface{

    public function __construct(CalculPrixCommandeService $prixCommande,EntityManagerInterface $entityManager)
    {
        $this->prixCommande=$prixCommande;
        $this->entityManager=$entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Commande;
    }

    public function persist($data, array $context = [])
    {
    
        if ($data instanceof Commande) {
            $data->setNumeroCommande($data->getNumeroCommande());               
            $this->prixCommande->montantCommande($data);               
        }
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }

}