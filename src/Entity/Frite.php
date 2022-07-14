<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\Response;


#[ORM\Entity(repositoryClass: FriteRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['liste-simple', 'liste-all']],
    denormalizationContext: ['groups' => ['liste-simple', 'liste-all']]
)]
class Frite extends Produit
{

    #[ORM\OneToMany(mappedBy: 'frite', targetEntity: MenuFrite::class)]
    private $menuFrites;

    #[ORM\OneToMany(mappedBy: 'frite', targetEntity: CommandeFrite::class)]
    private $commandeFrites;

    /* #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank(message: "Le Nom est Obligatoire")]
    #[Groups(["liste-simple", 'liste-all', "ecrire", 'liste-all_burger'])]
    private $nom; */

    public function __construct()
    {
        $this->menuFrites = new ArrayCollection();
        $this->commandeFrites = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuFrite>
     */
    public function getMenuFrites(): Collection
    {
        return $this->menuFrites;
    }

    public function addMenuFrite(MenuFrite $menuFrite): self
    {
        if (!$this->menuFrites->contains($menuFrite)) {
            $this->menuFrites[] = $menuFrite;
            $menuFrite->setFrite($this);
        }

        return $this;
    }

    public function removeMenuFrite(MenuFrite $menuFrite): self
    {
        if ($this->menuFrites->removeElement($menuFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuFrite->getFrite() === $this) {
                $menuFrite->setFrite(null);
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
            $commandeFrite->setFrite($this);
        }

        return $this;
    }

    public function removeCommandeFrite(CommandeFrite $commandeFrite): self
    {
        if ($this->commandeFrites->removeElement($commandeFrite)) {
            // set the owning side to null (unless already changed)
            if ($commandeFrite->getFrite() === $this) {
                $commandeFrite->setFrite(null);
            }
        }

        return $this;
    }

}
