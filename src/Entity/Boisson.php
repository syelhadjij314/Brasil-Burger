<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['liste-boisson']],
    denormalizationContext:['groups' => ['liste-boisson']]
)]
class Boisson extends Produit
{

    #[Groups(['liste-all','liste-boisson'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: MenuBoisson::class,cascade:['persist'])]
    // #[Groups(['menu-simple'])]

    private $menuBoissons;

    /* #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le Libelle est Obligatoire")]
    #[Groups(["liste-simple", 'liste-all', "ecrire", 'liste-all_burger','liste-boisson'])]
    private $nom; */

    public function __construct()
    {
        $this->menuBoissons = new ArrayCollection();
    
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
            $menuBoisson->setBoisson($this);
        }

        return $this;
    }

    public function removeMenuBoisson(MenuBoisson $menuBoisson): self
    {
        if ($this->menuBoissons->removeElement($menuBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuBoisson->getBoisson() === $this) {
                $menuBoisson->setBoisson(null);
            }
        }

        return $this;
    }

}
