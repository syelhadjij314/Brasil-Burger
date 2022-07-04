<?php

namespace App\DataPersister;

use ORM\Column;
use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Boisson;
use App\Entity\Produit;
use App\Services\MailerService;
use App\Services\CalculatorMenuService;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\Mapping as ORM;



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

            $prix=$this->calculatorMenuService->priceMenu($data);
            // dd($data->getBurgers());
            $data->setPrix($prix);

        }
        if ($data instanceof Boisson) {
            
            
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
