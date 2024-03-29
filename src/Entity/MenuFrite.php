<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuFriteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: MenuFriteRepository::class)]
#[ApiResource(
    normalizationContext:['groups'=> ["menu-simple"]],
    denormalizationContext:['groups'=> ["menu-simple"]]
)]
class MenuFrite
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
    private $quantiteFrite;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuFrites')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Frite::class, inversedBy: 'menuFrites',cascade:['persist'])]
    #[Groups(['menu-simple',"detail:read"])]
    private $frite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteFrite(): ?int
    {
        return $this->quantiteFrite;
    }

    public function setQuantiteFrite(int $quantiteFrite): self
    {
        $this->quantiteFrite = $quantiteFrite;

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

    public function getFrite(): ?Frite
    {
        return $this->frite;
    }

    public function setFrite(?Frite $frite): self
    {
        $this->frite = $frite;

        return $this;
    }
}
