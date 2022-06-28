<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource]

class Gestionnaire extends User
{
    
}
