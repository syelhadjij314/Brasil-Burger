<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProduitCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitCommandeRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['liste-simple','liste-all','menu-simple']],
    denormalizationContext:['groups' => ['liste-simple', 'liste-all','menu-simple']],
)]
class ProduitCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(["menu-simple"])]
    private $quantiteProduit;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'produitCommandes')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'produitCommandes')]
    #[Groups(["menu-simple"])]
    private $produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteProduit(): ?float
    {
        return $this->quantiteProduit;
    }

    public function setQuantiteProduit(float $quantiteProduit): self
    {
        $this->quantiteProduit = $quantiteProduit;

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

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

}
