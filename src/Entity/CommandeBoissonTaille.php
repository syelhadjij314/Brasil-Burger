<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeBoissonTailleRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CommandeBoissonTailleRepository::class)]
#[ApiResource]
class CommandeBoissonTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['commande-simple'])]
    #[Assert\NotBlank(message: "La quantite est requise")]
    #[Assert\Positive(message:"La quantite ne doit pas etre nulle")]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'commandeBoissonTailles')]
    #[Groups(['commande-simple'])]
    private ?BoissonTaille $boissonTaille = null;

    #[ORM\ManyToOne(inversedBy: 'commandeBoissonTailles')]
    private ?Commande $commande = null;


    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoissonTaille(): ?BoissonTaille
    {
        return $this->boissonTaille;
    }

    public function setBoissonTaille(?BoissonTaille $boissonTaille): self
    {
        $this->boissonTaille = $boissonTaille;

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

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
