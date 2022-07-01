<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Produit;
use App\Services\MailerService;
use App\Services\CalculatorMenuService;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class DataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $encoder,
        mailerService $mailerService,
        CalculatorMenuService $calculatorMenuService

    ) 
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
        $this->mailerService = $mailerService;
        $this->calculatorMenuService = $calculatorMenuService;

    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        // dd($data instanceof Produit);
        return $data instanceof User || $data instanceof Produit;
    }


    public function persist($data, array $context = [])
    {
        if ($data instanceof User) {

            if ($data->getPlainPassword()) {
                $password = $this->encoder->hashPassword($data, $data->getPlainPassword());
                $data->setPassword($password);
                // dd($data);
                $data->eraseCredentials();

                $this->mailerService->send($data);
            }
        }
        if ($data instanceof Menu) {
            // dd($data->getBurgers());
        // dd($data->getBurgers()[0]);

            $prix=$this->calculatorMenuService->priceMenu($data);
            // dd($data->getBurgers());
            $data->setPrix($prix);
            // dd($data);
            /* $prix=0;

            foreach ($data->getBurgers() as $burger) {
                $prix+=$burger->getPrix();
            }

            foreach ($data->getBoissons() as $boisson) {
                $prix+=$boisson->getPrix();
            }
            
            foreach ($data->getFrites() as $frite) {
                $prix+=$frite->getPrix();
            }
            $data->setPrix($prix); */
            // dd($data->getPrix());
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
