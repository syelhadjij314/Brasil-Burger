<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenuBoissonRepository::class)]
#[ApiResource(
    normalizationContext:['groups'=> ["menu-simple"]],
    denormalizationContext:['groups'=> ["menu-simple"]]
)]
class MenuBoisson
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
    private $quantiteBoisson;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBoissons')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'menuBoissons',cascade:['persist'])]
    #[Groups(['menu-simple',"detail:read"])]
    private $boisson;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteBoisson(): ?int
    {
        return $this->quantiteBoisson;
    }

    public function setQuantiteBoisson(int $quantiteBoisson): self
    {
        $this->quantiteBoisson = $quantiteBoisson;

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

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }
}
