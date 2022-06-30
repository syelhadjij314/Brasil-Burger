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



#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["user" => "User","client" => "Client","gestionnaire" => "Gestionnaire"])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
        'normalization_context' => ['groups' => ['liste-user-simple']]

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
        "get",
        "put"
        ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['liste-all','user:read:simple','liste-user','liste-user-simple','liste-user-all'])]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(['liste-all','user:read:simple','liste-user','liste-user-simple','liste-user-all'])]
    protected $login;

    #[ORM\Column(type: 'json')]
    #[Groups(['user:read:simple','liste-user-simple','liste-user','liste-user-all'])]
    protected $roles = [];

    #[ORM\Column(type: 'string')]
    protected $password;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    #[ApiSubresource]
    protected $produits;

    #[SerializedName('password')]
    protected $PlainPassword;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    protected $token;

    #[ORM\Column(type: 'boolean',nullable: true)]
    protected $is_enable;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    #[Groups(['liste-all','liste-user','liste-user-simple','liste-user-all'])]
    protected $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Le prenom est Obligatoire")]
    #[Groups(['liste-all','liste-user','liste-user-simple','liste-user-all'])]
    protected $prenom;

    #[ORM\Column(type: 'datetime')]
    protected $expireAt;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->is_enable= false;
        $this->generateToken();
        $roleDefault=get_called_class();
        $roleDefault= explode("\\" ,$roleDefault);
        $roleDefault=strtoupper($roleDefault[2]);
        return $this->roles= ["ROLE_VISITEUR","ROLE_".$roleDefault];
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
        return array_unique($roles);
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

}
