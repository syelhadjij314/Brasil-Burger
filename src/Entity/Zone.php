<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['liste-simple','liste-all','menu-simple','commande-simple','zone-read']],
    denormalizationContext:['groups' => ['liste-simple', 'liste-all','menu-simple','commande-simple']],
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
    #[Groups(['commande-simple','zone-read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique:true)]
    #[Assert\NotBlank(message: "Le Nom est Obligatoire")]
    #[Groups(['commande-simple','zone-read'])]

    private $nom;

    #[ORM\Column(type: 'float')]
    #[Assert\NotBlank(message: "Le Prix est Obligatoire")]
    #[Groups(['commande-simple','zone-read'])]

    private $prix;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    #[Groups(['zone-read'])]
    private $quartiers;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'zones')]
    // #[Groups(['commande-simple'])]
    private $gestionnaire;

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

    public function getGestionnaire(): ?User
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?User $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }
}
