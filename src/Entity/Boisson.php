<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['liste-simple','liste-all']],
    denormalizationContext:['groups' => ['liste-simple', 'liste-all']],
)]
class Boisson extends Produit
{
    
    #[Groups(['liste-all'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $taille;

    

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'boissons')]
    private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }


    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }
    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addBoisson($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeBoisson($this);
        }

        return $this;
    }

}
