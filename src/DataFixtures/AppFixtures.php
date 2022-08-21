<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Livreur;
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
       /*  $user = new User();
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
 */        
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

        /* $user2=new Gestionnaire();
        $user2->setLogin('gestionnaire1@gmail.com');
        $user2->setNom('Sarr');
        $user2->setPrenom('Bintou');
        $hashedPassword = $this->passwordHasher->hashPassword(
        $user2,
        'gestionnaire'
        );
        $user2->setPassword($hashedPassword);
        $user2->setRoles(['ROLE_GESTIONNAIRE']); */

        /* $user3=new Client();
        $user3->setLogin('client1@gmail.com');
        $user3->setNom('Deme');
        $user3->setPrenom('Abdoulaye');
        $user3->setAdresse("Thiaroye");
        $user3->setTelephone("701234567");
        $has3dPassword = $this->passwordHasher->hashPassword(
        $user3,
        'client'
        );
        $user3->setPassword($hashedPassword);
        $user3->setRoles(['ROLE_CLIENT']); */

        $user4=new Livreur();
        $user4->setLogin('livreur@gmail.com');
        $user4->setNom('Ndiaye');
        $user4->setPrenom('Abdoulaye');
        $user4->setExpireAt(new \DateTime("+1 days"));

        // $user4->setMatriculeMoto('L00123');
        $user4->setTelephone('750120786');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user4,
            'passer'
        );
        $user4->setPassword($hashedPassword);
        $user4->setRoles(['ROLE_LIVREUR']);

        $user5=new Livreur();
        $user5->setLogin('livreur1@gmail.com');
        $user5->setNom('Ndiaye');
        $user5->setPrenom('Abdoulaye');
        $user5->setMatriculeMoto('L00456');
        $user5->setTelephone('782377733');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user5,
            'passer'
        );
        $user5->setPassword($hashedPassword);
        $user5->setRoles(['ROLE_LIVREUR']);
        $user5->setExpireAt(new \DateTime("+1 days"));
        $manager->persist($user4);
        $manager->persist($user5);
        // $manager->flush();

        $manager->flush();
    }
}
