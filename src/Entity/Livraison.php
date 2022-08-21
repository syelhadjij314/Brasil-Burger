<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    normalizationContext:['groups' => ['livraison-read-simple']],
    denormalizationContext:['groups' => ['livraison-read-all']],
    collectionOperations: [
        "get",    
        "post" => [ "security_post_denormalize" => "is_granted('ACCESS_CREATE', object)" ],
    ],
    itemOperations: [
        "get" => [ "security" => "is_granted('ACCESS_READ', object)" ],
        "put",
        "delete" => [ "security" => "is_granted('ACCESS_DELETE', object)" ],
    ],

)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['livraison-read-simple'])]
    private $id;

    #[ORM\Column(type: 'float',nullable:true)]
    private $montantTolal;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    #[Groups(['livraison-read-all','livraison-read-simple'])]
    private $commandes;

    #[ORM\ManyToOne(inversedBy: 'livraisons')]
    #[Groups(['livraison-read-all','livraison-read-simple'])]
    private ?Livreur $livreur = null;

    #[ORM\Column(length: 255)]
    #[Groups(['livraison-read-simple'])]
    private ?string $etat = "en cours";

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantTolal(): ?float
    {
        return $this->montantTolal;
    }

    public function setMontantTolal(float $montantTolal): self
    {
        $this->montantTolal = $montantTolal;

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
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
