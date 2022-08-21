<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Controller\EmailValidateController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


// #[ORM\table(name:"utilisateur")]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["user" => "User","client" => "Client","gestionnaire" => "Gestionnaire","livreur" => "Livreur"])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    /* subresourceOperations:[
        'api_commandes_user_get_subresource' => [
            'method' => 'GET',
            'normalization_context' => [
                'groups' => ['commandes-user-read'],
            ],
            'denormalization_context' => [
                'groups' => ['commandes-user-read'],
            ],
        ],
    ], */
    collectionOperations:[
        "get"=>[
        'normalization_context' => ['groups' => ['liste-user-simple','commande-simple']]
        ],
        "post",
        "VALIDATION" => [
        "method"=>"PATCH",
        'deserialize' => false,
        'path'=>'users/validate/{token}',
        'controller' => EmailValidateController::class,

        ]
    ],
    itemOperations:[
        "get"=>[
            'normalization_context' => ['groups' => ['commande-simple']],
            'denormalization_context' => ['groups' => ['commande-simple']]
        ],
        "put"
        ]
)]
// #[ORM\Table("utilisateur")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['liste-simple','liste-all','user:read:simple','liste-user','liste-user-simple','liste-user-all','liste-boisson','commande-simple','livreur:read:simple','livraison-read-all'])]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(['liste-all','user:read:simple','liste-user','liste-user-simple','liste-user-all','liste-boisson','livreur-read-simple','livreur-read-all','commande-simple'])]
    protected $login;

    #[ORM\Column(type: 'json')]
    #[Groups(['user:read:simple','liste-user-simple','liste-user','livreur-read-all','commande-simple'])]
    protected $roles;

    #[ORM\Column(type: 'string')]
    protected $password;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    #[ApiSubresource]
    protected $produits;

    #[SerializedName('password')]
    #[Groups(['livreur-read-all'])]
    protected $PlainPassword;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    #[Groups(['livreur-read-all'])]
    protected $token;

    #[ORM\Column(type: 'boolean',nullable: true)]
    #[Groups(['livreur-read-all'])]
    protected $is_enable;

    #[ORM\Column(type: 'datetime',nullable: true)]
    #[Groups(['livreur-read-all'])]
    protected $expireAt;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    #[Groups(['liste-all','liste-user','liste-user-simple','liste-user-all','liste-boisson','commandes-user-read','livreur-read-simple','livreur-read-all','commande-simple','livraison-read-simple'])]
    protected $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Le prenom est Obligatoire")]
    #[Groups(['liste-all','liste-user','liste-user-simple','liste-user-all','liste-boisson','commandes-user-read','livreur-read-simple','livreur-read-all','commande-simple','livraison-read-simple'])]
    protected $prenom;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    #[ApiSubresource]
    #[Groups(['commande-simple'])]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Zone::class)]
    private $zones;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Quartier::class)]
    private $quartiers;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Taille::class)]
    private Collection $tailles;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->is_enable= false;
        $this->generateToken();
        $roleDefault=get_called_class();
        $roleDefault= explode("\\" ,$roleDefault);
        $roleDefault=strtoupper($roleDefault[2]);
        return $this->roles= ["ROLE_VISITEUR","ROLE_".$roleDefault];
        $this->commandes = new ArrayCollection();
        $this->zones = new ArrayCollection();
        $this->quartiers = new ArrayCollection();
        $this->tailles = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // $this->roles=["ROLE_VISITEUR"];
        return ($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $produit->setGestionnaire($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getGestionnaire() === $this) {
                $produit->setGestionnaire(null);
            }
        }

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->PlainPassword;
    }

    public function setPlainPassword(string $PlainPassword): self
    {
        $this->PlainPassword = $PlainPassword;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function isIsEnable(): ?bool
    {
        return $this->is_enable;
    }

    public function setIsEnable(bool $is_enable): self
    {
        $this->is_enable = $is_enable;

        return $this;
    }

    public function getExpireAt(): ?\datetime
    {
        return $this->expireAt;
    }

    public function setExpireAt(\datetime $expireAt): self
    {
        $this->expireAt = $expireAt;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function generateToken()
    {
        $this->token= rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $this->expireAt= new \DateTime("+1 days");

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
            $commande->setGestionnaire($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getGestionnaire() === $this) {
                $commande->setGestionnaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Zone>
     */
    public function getZones(): Collection
    {
        return $this->zones;
    }

    public function addZone(Zone $zone): self
    {
        if (!$this->zones->contains($zone)) {
            $this->zones[] = $zone;
            $zone->setGestionnaire($this);
        }

        return $this;
    }

    public function removeZone(Zone $zone): self
    {
        if ($this->zones->removeElement($zone)) {
            // set the owning side to null (unless already changed)
            if ($zone->getGestionnaire() === $this) {
                $zone->setGestionnaire(null);
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
            $quartier->setGestionnaire($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartiers->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getGestionnaire() === $this) {
                $quartier->setGestionnaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles->add($taille);
            $taille->setGestionnaire($this);
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        if ($this->tailles->removeElement($taille)) {
            // set the owning side to null (unless already changed)
            if ($taille->getGestionnaire() === $this) {
                $taille->setGestionnaire(null);
            }
        }

        return $this;
    }

}
