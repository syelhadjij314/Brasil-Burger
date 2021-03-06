<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher=$passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setLogin('gestionnaire@gmail.com');
        $user->setPrenom('Mor');
        $user->setNom('Diouf');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'passer'
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_GESTIONNAIRE']);
        $manager->persist($user);
        
        /* $user1 = new User();
        $user1->setLogin('gestionnaire@gmail.com');
        $user1->setPrenom('Mor');
        $user1->setNom('Diouf');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user1,
            'passer'
        );
        $user1->setPassword($hashedPassword);
        $user1->setRoles(['ROLE_GESTIONNAIRE']); */
        // $manager->persist($user1);

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
