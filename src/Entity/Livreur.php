<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['livreur-read-simple','user:read:simple','liste-user']],
    denormalizationContext:['groups' => ['livreur-read-all']],
    collectionOperations:[
        "get",
        "post",
    ],
    itemOperations:[
        "get",
        "put"
    ]
)]
class Livreur extends User
{
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['livreur:read:simple','user:read:simple','liste-user','livraison-read-simple'])]
    private $matriculeMoto;

    #[ORM\Column(type: 'integer')]
    #[Groups(['livreur:read:simple','livreur-read-all','liste-simple','liste-all','user:read:simple','liste-user','liste-user-simple','liste-user-all','livraison-read-simple'])]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['livraison-read-simple'])]
    private $etat="disponible";

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    #[ApiSubresource()]
    private Collection $livraisons;

    public function __construct()
    {
        parent::__construct();
        $this->livraisons = new ArrayCollection();
        $this->matriculeMoto="MOTO-".date('ymdhis');
        // $this->setRoles([0=>'ROLE_LIVREUR']);
        // dd(parent::getRoles());
    }

    public function getMatriculeMoto(): ?string
    {
        return $this->matriculeMoto;
    }

    public function setMatriculeMoto(string $matriculeMoto): self
    {
        $this->matriculeMoto = $matriculeMoto;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

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

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons->add($livraison);
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
            }
        }

        return $this;
    }
}
