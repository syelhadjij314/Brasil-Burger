<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonTailleRepository::class)]
#[ApiResource]
class BoissonTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['liste-all','liste-boisson',"detail:read"])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantiteStock = null;

    #[ORM\ManyToOne(inversedBy: 'boissonTailles')]
    #[Groups(['liste-all','liste-boisson',"detail:read"])]

    private ?Boisson $boisson = null;

    #[ORM\ManyToOne(inversedBy: 'boissonTailles')]
    #[Groups(['liste-all','liste-boisson',"detail:read"])]

    private ?Taille $taille = null;

    #[ORM\OneToMany(mappedBy: 'boissonTaille', targetEntity: CommandeBoissonTaille::class)]
    private Collection $commandeBoissonTailles;

    public function __construct()
    {
        $this->commandeBoissonTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteStock(): ?int
    {
        return $this->quantiteStock;
    }

    public function setQuantiteStock(?int $quantiteStock): self
    {
        $this->quantiteStock = $quantiteStock;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * @return Collection<int, CommandeBoissonTaille>
     */
    public function getCommandeBoissonTailles(): Collection
    {
        return $this->commandeBoissonTailles;
    }

    public function addCommandeBoissonTaille(CommandeBoissonTaille $commandeBoissonTaille): self
    {
        if (!$this->commandeBoissonTailles->contains($commandeBoissonTaille)) {
            $this->commandeBoissonTailles->add($commandeBoissonTaille);
            $commandeBoissonTaille->setBoissonTaille($this);
        }

        return $this;
    }

    public function removeCommandeBoissonTaille(CommandeBoissonTaille $commandeBoissonTaille): self
    {
        if ($this->commandeBoissonTailles->removeElement($commandeBoissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($commandeBoissonTaille->getBoissonTaille() === $this) {
                $commandeBoissonTaille->setBoissonTaille(null);
            }
        }

        return $this;
    }
}
