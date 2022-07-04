<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;


#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['liste-simple','liste-all']],
    denormalizationContext:['groups' => ['liste-simple', 'liste-all']],
)]
class Menu extends Produit
{

    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    #[ApiSubresource()]
    #[Groups(['liste-all'])]
    #[Assert\NotBlank(message: "il faut ajouter au moins 1 burger")]
    #[Assert\Count(min:1)]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: Frite::class, inversedBy: 'menus')]
    #[ApiSubresource]
    #[Groups(['liste-all'])]
    #[Assert\NotBlank(message: "Le Nom est Obligatoire")]
    #[Assert\Count(min:1)]

    private $frites;

    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'menus')]
    #[ApiSubresource]
    #[Groups(['liste-all'])]
    #[Assert\NotBlank(message: "Le Nom est Obligatoire")]
    #[Assert\Count(min:1)]

    private $boissons;

    public function __construct()
    {
        $this->burgers = new ArrayCollection();
        $this->frites = new ArrayCollection();
        $this->boissons = new ArrayCollection();
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        $this->burgers->removeElement($burger);

        return $this;
    }

    /**
     * @return Collection<int, Frite>
     */
    public function getFrites(): Collection
    {
        return $this->frites;
    }

    public function addFrite(Frite $frite): self
    {
        if (!$this->frites->contains($frite)) {
            $this->frites[] = $frite;
        }

        return $this;
    }

    public function removeFrite(Frite $frite): self
    {
        $this->frites->removeElement($frite);

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }


}
