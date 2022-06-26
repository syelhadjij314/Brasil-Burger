<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource()]
class Burger extends Produit
{
    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'burgers')]
    private $menu;

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    

}
