<?php
namespace App\DataPersister;

use App\Entity\Commande;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\CalculPrixCommandeService;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class CommandeDataPersister implements ContextAwareDataPersisterInterface{

    public function __construct(CalculPrixCommandeService $prixCommande,MailerService $mailerService,EntityManagerInterface $entityManager)
    {
        $this->prixCommande=$prixCommande;
        $this->entityManager=$entityManager;
        $this->mailerService = $mailerService;
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
            $this->mailerService->send($data,"Confirmation de Commande",$data->getClient()->getLogin());
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