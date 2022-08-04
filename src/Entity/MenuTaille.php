<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: MenuTailleRepository::class)]
#[ApiResource(
    normalizationContext:['groups'=> ["menu-simple"]],
    denormalizationContext:['groups'=> ["menu-simple"]]
)]
class MenuTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['menu-simple'])]

    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['menu-simple',"detail:read"])]
    #[SerializedName("quantite")]
    #[Assert\NotBlank(message: "La quantite est requise")]
    #[Assert\Positive(message:"La quantite ne doit pas etre nulle")]
    private ?int $quantiteTailleBoisson = null;

    #[ORM\ManyToOne(inversedBy: 'menuTailles')]
    private ?Menu $menu = null;
    
    #[ORM\ManyToOne(inversedBy: 'menuTailles',cascade:['persist'])]
    #[Groups(['menu-simple',"detail:read"])]
    private ?Taille $taille = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteTailleBoisson(): ?int
    {
        return $this->quantiteTailleBoisson;
    }

    public function setQuantiteTailleBoisson(int $quantiteTailleBoisson): self
    {
        $this->quantiteTailleBoisson = $quantiteTailleBoisson;

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

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }
}
