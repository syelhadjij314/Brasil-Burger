<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeFriteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommandeFriteRepository::class)]
#[ApiResource]
class CommandeFrite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['commande-simple'])]
    #[Assert\NotBlank(message: "La quantite est requise")]
    #[Assert\Positive(message:"La quantite ne doit pas etre nulle")]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Frite::class, inversedBy: 'commandeFrites')]
    #[Groups(['commande-simple'])]
    private $frite;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeFrites')]
    private $commande;

    #[ORM\Column(type: 'float')]
    private $prix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFrite(): ?Frite
    {
        return $this->frite;
    }

    public function setFrite(?Frite $frite): self
    {
        $this->frite = $frite;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
