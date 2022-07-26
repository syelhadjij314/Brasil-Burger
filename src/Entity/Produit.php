<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["produit" => "Produit", "burger" => "Burger", "menu" => "Menu", "frite" => "Frite", "boisson" => "Boisson"])]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['liste-simple','liste-simple-read','liste-all','menu-simple','liste-boisson']],
    denormalizationContext:['groups' => ['liste-simple', 'liste-all','menu-simple','liste-boisson',"image-read"]],
    collectionOperations: [
        "get",
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
    #[Groups(["liste-simple",'liste-all',"ecrire",'liste-all_burger','menu-simple','liste-boisson',"image-read"])]
    protected $id;

    #[ORM\Column(type: 'integer')]
    // #[Assert\NotBlank(message:"Le Prix est Obligatoire")]
    #[Groups(["liste-simple", 'liste-all', "ecrire", 'liste-all_burger','liste-boisson'])]
    protected $prix;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['liste-all', "ecrire",'liste-boisson'])]
    protected $isEtat=true;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'produits')]
    #[Groups(['liste-all','liste-boisson'])]
    protected $gestionnaire;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Le Nom est Obligatoire")]
    // #[Assert\Unique()]
    #[Groups(["liste-simple", 'liste-all', "ecrire", 'liste-all_burger'])]
    protected $nom;

    #[ORM\Column(type: 'blob', nullable: true)]
    #[Groups(['liste-simple-read'])]
    protected $image;

    #[SerializedName("image")]
    #[Groups(["liste-simple"])]
    protected $imageString;

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage()
    {

        return is_resource($this->image) ? (base64_encode(stream_get_contents($this->image))) : ($this->image);
        
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }


    /**
     * Get the value of imageString
     */ 
    public function getImageString()
    {
        return $this->imageString;
    }

    /**
     * Set the value of imageString
     *
     * @return  self
     */ 
    public function setImageString($imageString)
    {
        $this->imageString = $imageString;

        return $this;
    }
}
