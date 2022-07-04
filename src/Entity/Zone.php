<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    // attributes: ["security" => "is_granted('ROLE_GESTIONNAIRE')"],
    collectionOperations: [
        "get",
        "post" => [ "security_post_denormalize" => "is_granted('ACCESS_CREATE', object)" ],
    ],
    itemOperations: [
        "get" => [ "security" => "is_granted('ACCESS_READ', object)" ],
        "put" => [ "security" => "is_granted('ACCESS_EDIT', object)" ],
        "delete" => [ "security" => "is_granted('ACCESS_DELETE', object)" ],
    ],
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique:true)]
    #[Assert\NotBlank(message: "Le Nom est Obligatoire")]
    private $nom;

    #[ORM\Column(type: 'float')]
    #[Assert\NotBlank(message: "Le Prix est Obligatoire")]
    private $prix;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    private $quartiers;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->quartiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
            $commande->setZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getZone() === $this) {
                $commande->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quartier>
     */
    public function getQuartiers(): Collection
    {
        return $this->quartiers;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartiers->contains($quartier)) {
            $this->quartiers[] = $quartier;
            $quartier->setZone($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartiers->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getZone() === $this) {
                $quartier->setZone(null);
            }
        }

        return $this;
    }
}
