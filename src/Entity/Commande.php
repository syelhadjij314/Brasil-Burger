<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Services\CallbackCommandeService;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;


#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['liste-simple','liste-all','menu-simple','commande-simple']],
    denormalizationContext:['groups' => ['liste-simple', 'liste-all','menu-simple','commande-simple']],
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

#[Assert\Callback([CallbackCommandeService::class, 'validate'])]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['commande-simple'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $numeroCommande;

    #[ORM\Column(type: 'datetime')]
    private $dateAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $etat="disponible";

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandes')]
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandes')]
    private $client;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[Groups(['commande-simple'])]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    // #[Groups(["menu-simple"])]
    private $livraison;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['commande-simple'])]
    private $montant;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeBoisson::class,cascade:["persist"])]
    #[SerializedName('boissons')]
    #[Groups(['commande-simple'])]
    // #[Assert\NotBlank(message: "Ajouter au moins un boisson")]
    #[Assert\Valid()]
    private $commandeBoissons;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeBurger::class,cascade:["persist"])]
    #[SerializedName('burgers')]
    #[Groups(['commande-simple'])]
    #[Assert\Count(min:1,minMessage:"Ajouter au moins 1 burger")]
    #[Assert\Valid()]
    private $commandeBurgers;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeFrite::class,cascade:["persist"])]
    #[SerializedName('frites')]
    #[Groups(['commande-simple'])]
    #[Assert\Valid()]
    private $commandeFrites;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeMenu::class,cascade:["persist"])]
    #[SerializedName('menus')]
    #[Groups(['commande-simple'])]
    #[Assert\Count(min:1,minMessage:"Ajouter au moins 1 burger")]
    #[Assert\Valid()]
    private $commandeMenus;

    public function __construct()
    {
        $this->numeroCommande= "NUM".date('ymdhis');
        $this->produitCommandes = new ArrayCollection();
        $this->dateAt = new \DateTime();
        $this->commandeBoissons = new ArrayCollection();
        $this->commandeBurgers = new ArrayCollection();
        $this->commandeFrites = new ArrayCollection();
        $this->commandeMenus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCommande(): ?string
    {
        return $this->numeroCommande;
    }

    public function setNumeroCommande(string $numeroCommande): self
    {
        $this->numeroCommande = $numeroCommande;

        return $this;
    }

    public function getDateAt(): ?\DateTime
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTime $dateAt): self
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

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

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * @return Collection<int, CommandeBoisson>
     */
    public function getCommandeBoissons(): Collection
    {
        return $this->commandeBoissons;
    }

    public function addCommandeBoisson(CommandeBoisson $commandeBoisson): self
    {
        if (!$this->commandeBoissons->contains($commandeBoisson)) {
            $this->commandeBoissons[] = $commandeBoisson;
            $commandeBoisson->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeBoisson(CommandeBoisson $commandeBoisson): self
    {
        if ($this->commandeBoissons->removeElement($commandeBoisson)) {
            // set the owning side to null (unless already changed)
            if ($commandeBoisson->getCommande() === $this) {
                $commandeBoisson->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeBurger>
     */
    public function getCommandeBurgers(): Collection
    {
        return $this->commandeBurgers;
    }

    public function addCommandeBurger(CommandeBurger $commandeBurger): self
    {
        if (!$this->commandeBurgers->contains($commandeBurger)) {
            $this->commandeBurgers[] = $commandeBurger;
            $commandeBurger->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeBurger(CommandeBurger $commandeBurger): self
    {
        if ($this->commandeBurgers->removeElement($commandeBurger)) {
            // set the owning side to null (unless already changed)
            if ($commandeBurger->getCommande() === $this) {
                $commandeBurger->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeFrite>
     */
    public function getCommandeFrites(): Collection
    {
        return $this->commandeFrites;
    }

    public function addCommandeFrite(CommandeFrite $commandeFrite): self
    {
        if (!$this->commandeFrites->contains($commandeFrite)) {
            $this->commandeFrites[] = $commandeFrite;
            $commandeFrite->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeFrite(CommandeFrite $commandeFrite): self
    {
        if ($this->commandeFrites->removeElement($commandeFrite)) {
            // set the owning side to null (unless already changed)
            if ($commandeFrite->getCommande() === $this) {
                $commandeFrite->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeMenu>
     */
    public function getCommandeMenus(): Collection
    {
        return $this->commandeMenus;
    }

    public function addCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if (!$this->commandeMenus->contains($commandeMenu)) {
            $this->commandeMenus[] = $commandeMenu;
            $commandeMenu->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if ($this->commandeMenus->removeElement($commandeMenu)) {
            // set the owning side to null (unless already changed)
            if ($commandeMenu->getCommande() === $this) {
                $commandeMenu->setCommande(null);
            }
        }

        return $this;
    }

    
}
