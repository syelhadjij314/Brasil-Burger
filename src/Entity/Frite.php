<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FriteRepository::class)]
#[ApiResource]
class Frite extends Produit
{
    

    #[ORM\ManyToMany(targetEntity: Complement::class, mappedBy: 'frites')]
    private $complements;

    public function __construct()
    {
        $this->complements = new ArrayCollection();
    }

    /**
     * @return Collection<int, Complement>
     */
    public function getComplements(): Collection
    {
        return $this->complements;
    }

    public function addComplement(Complement $complement): self
    {
        if (!$this->complements->contains($complement)) {
            $this->complements[] = $complement;
            $complement->addFrite($this);
        }

        return $this;
    }

    public function removeComplement(Complement $complement): self
    {
        if ($this->complements->removeElement($complement)) {
            $complement->removeFrite($this);
        }

        return $this;
    }
}
