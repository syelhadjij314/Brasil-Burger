<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProduitCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitCommandeRepository::class)]
#[ApiResource]
class ProduitCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $quantiteProduit;

    #[ORM\OneToMany(mappedBy: 'produitCommande', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'produitCommande', targetEntity: Produit::class)]
    private $produits;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setProduitCommande($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getProduitCommande() === $this) {
                $commande->setProduitCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setProduitCommande($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getProduitCommande() === $this) {
                $produit->setProduitCommande(null);
            }
        }

        return $this;
    }
}
