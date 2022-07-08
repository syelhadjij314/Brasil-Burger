<?php
namespace App\DataPersister;

use App\Entity\Commande;

class CommandeDataPersister{

    /* public function __construct()
    {
        $this->numeroCommande=$numeroCommande;
    } */

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
            // $num= new \DateTime();
            $data->setNumeroCommande($data->getNumeroCommande());
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