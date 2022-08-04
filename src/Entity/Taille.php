<?php

namespace App\Entity;

use App\Entity\MenuTaille;
use App\Entity\BoissonTaille;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\Response;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['liste-boisson']],
    denormalizationContext:['groups' => ['liste-boisson']],
    
)]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["liste-simple",'liste-all',"ecrire",'liste-all_burger','menu-simple','liste-boisson',"image-read",'catalogue:read',"detail:read"])]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['liste-all','liste-boisson',"detail:read"])]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: BoissonTaille::class,cascade:['persist'])]
    private Collection $boissonTailles;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: MenuTaille::class,cascade:['persist'])]
    private Collection $menuTailles;

    #[ORM\Column(nullable: true)]
    #[Groups(['liste-all','liste-boisson',"detail:read"])]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'tailles')]
    private ?User $gestionnaire = null;

    public function __construct()
    {
        $this->boissonTailles = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailles(): Collection
    {
        return $this->boissonTailles;
    }

    public function addBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if (!$this->boissonTailles->contains($boissonTaille)) {
            $this->boissonTailles->add($boissonTaille);
            $boissonTaille->setTaille($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getTaille() === $this) {
                $boissonTaille->setTaille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenuTailles(): Collection
    {
        return $this->menuTailles;
    }

    public function addMenuTaille(MenuTaille $menuTaille): self
    {
        if (!$this->menuTailles->contains($menuTaille)) {
            $this->menuTailles->add($menuTaille);
            $menuTaille->setTaille($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTaille $menuTaille): self
    {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getTaille() === $this) {
                $menuTaille->setTaille(null);
            }
        }

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

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
