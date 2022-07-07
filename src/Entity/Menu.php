<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Services\CallbackMenuService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;


#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['liste-simple','liste-all','menu-simple']],
    denormalizationContext:['groups' => ['liste-simple', 'liste-all','menu-simple']],
)]

#[Assert\Callback([CallbackMenuService::class, 'validate'])]

class Menu extends Produit
{

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBoisson::class,cascade:['persist'])]
    #[ApiSubresource]
    #[Groups(["menu-simple"])]
    #[SerializedName('boissons')]
    #[Assert\NotBlank(message: "Ajouter au moins un boisson")]
    #[Assert\Valid()]
    private $menuBoissons;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:['persist'])]
    #[ApiSubresource]
    #[Groups(["menu-simple"])]
    #[SerializedName('burgers')]
    #[Assert\Count(min:1,minMessage:"Ajouter au moins 1 burger")]
    #[Assert\Valid()]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuFrite::class,cascade:['persist'])]
    #[ApiSubresource]
    #[Groups(["menu-simple"])]   
    #[SerializedName('frites')]
    #[Assert\Valid()]
    private $menuFrites;

    public function __construct()
    {
        $this->menuBoissons = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuFrites = new ArrayCollection();
    }
    /**
     * @return Collection<int, MenuBoisson>
     */
    public function getMenuBoissons(): Collection
    {
        return $this->menuBoissons;
    }

    public function addMenuBoisson(MenuBoisson $menuBoisson): self
    {
        if (!$this->menuBoissons->contains($menuBoisson)) {
            $this->menuBoissons[] = $menuBoisson;
            $menuBoisson->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBoisson(MenuBoisson $menuBoisson): self
    {
        if ($this->menuBoissons->removeElement($menuBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuBoisson->getMenu() === $this) {
                $menuBoisson->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }
        return $this;
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
            $menuFrite->setMenu($this);
        }
        return $this;
    }
    public function removeMenuFrite(MenuFrite $menuFrite): self
    {
        if ($this->menuFrites->removeElement($menuFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuFrite->getMenu() === $this) {
                $menuFrite->setMenu(null);
            }
        }
        return $this;
    }

}
