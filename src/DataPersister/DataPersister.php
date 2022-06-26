<?php

namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Services\MailerService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct( EntityManagerInterface $entityManager, 
    UserPasswordHasherInterface $encoder,
    mailerService $mailerService )
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
        $this->mailerService=$mailerService;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
        if ($data->getPlainPassword()) {
            $password = $this->encoder->hashPassword($data,$data->getPlainPassword());
            $data->setPassword($password);
            $data->eraseCredentials();
            $this->entityManager->persist($data);
            
            $this->entityManager->flush();
            $this->mailerService->send($data);
        }
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