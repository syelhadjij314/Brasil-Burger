<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["produit" => "Produit", "burger" => "Burger", "menu" => "Menu", "frite" => "Frite", "boisson" => "Boisson"])]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['liste-simple','liste-all']],
    denormalizationContext:['groups' => ['liste-simple', 'liste-all']],
    collectionOperations: [
        "get" => [
            'method' => 'get',
            'status' => Response::HTTP_OK,
        ],
        "post"
        ],
        itemOperations: [
            "put" => [
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas accès à cette Ressource",
        ],
        "get" => [
            'method' => 'get',
            'status' => Response::HTTP_OK,
        ]
    ],
    // attributes: ["pagination_items_per_page"=> 5]
    )]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["liste-simple", 'liste-all', "ecrire", 'liste-all_burger'])]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le Nom est Obligatoire")]
    #[Groups(["liste-simple", 'liste-all', "ecrire", 'liste-all_burger'])]
    protected $nom;

    /* #[ORM\Column(type: 'object')]
    protected $image; */
    #[ORM\Column(type: 'integer')]
    // #[Assert\NotBlank(message:"Le Prix est Obligatoire")]
    #[Groups(["liste-simple", 'liste-all', "ecrire", 'liste-all_burger'])]
    protected $prix;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['liste-all', "ecrire"])]
    private $isEtat;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'produits')]
    #[Groups(['liste-all'])]
    private $gestionnaire;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'produits')]
    private $commandes;

    #[ORM\ManyToOne(targetEntity: ProduitCommande::class, inversedBy: 'produits')]
    private $produitCommande;

    public function __construct()
    {
        $this->isEtat = true;
        $this->commandes = new ArrayCollection();
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

    /*  public function getImage(): ?object
    {
        return $this->image;
    }

    public function setImage(object $image): self
    {
        $this->image = $image;

        return $this;
    }
 */
    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

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
            $commande->addProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeProduit($this);
        }

        return $this;
    }

    public function getProduitCommande(): ?ProduitCommande
    {
        return $this->produitCommande;
    }

    public function setProduitCommande(?ProduitCommande $produitCommande): self
    {
        $this->produitCommande = $produitCommande;

        return $this;
    }
}
