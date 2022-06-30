<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get",
        "post",
        "post_register" => [
            "method"=>"post",
            'path'=>'/register',
            'normalization_context' => ['groups' => ['user:read:simple']],
            'denormalization_context' => ['groups' => ['liste-user-all']],
            'normalization_context' => ['groups' => ['liste-user']]
        ],
    ],
    itemOperations:[
        "get",
        "put"
    ]
)]

class Gestionnaire extends User
{
    
}
