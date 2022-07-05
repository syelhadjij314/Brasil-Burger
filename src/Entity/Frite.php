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

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank(message: "Le Nom est Obligatoire")]
    #[Groups(["liste-simple", 'liste-all', "ecrire", 'liste-all_burger'])]
    private $nom;

    /* #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frites')]
    private $menus; */

    public function __construct()
    {
        // $this->menus = new ArrayCollection();
        $this->menuFrites = new ArrayCollection();
    }


    /**
     * @return Collection<int, Menu>
     */
    /*  public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addFrite($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeFrite($this);
        }

        return $this;
    } */

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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
