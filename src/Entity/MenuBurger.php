<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
#[ApiResource(
    normalizationContext:['groups'=> ["menu-simple"]],
    denormalizationContext:['groups'=> ["menu-simple"]]
)]
class MenuBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['menu-simple'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['menu-simple',"detail:read"])]
    #[SerializedName("quantite")]
    #[Assert\NotBlank(message: "La quantite est requise")]
    #[Assert\Positive(message:"La quantite ne doit pas etre nulle")]
    private $quantiteBurger;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBurgers')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    #[Groups(['menu-simple',"detail:read"])]
    #[Assert\NotBlank(message:"Il faut au moins un burger")]
    private $burger;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteBurger(): ?int
    {
        return $this->quantiteBurger;
    }

    public function setQuantiteBurger(int $quantiteBurger): self
    {
        $this->quantiteBurger = $quantiteBurger;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }
}
