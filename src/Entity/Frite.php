<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;


#[ORM\Entity(repositoryClass: FriteRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['liste-simple']],
        ] ,
        "post"=>[
            'denormalization_context' => ['groups' => ['liste-simple','liste-all']],
            'normalization_context' => ['groups' => ['liste-all']]
        ]],
    itemOperations:[
        "put"=>[
            "security"=> "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=> "Vous n'avez pas accès à cette Ressource",
        ],
        "get"=>[
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['liste-all']],
        ],
        ])]
class Frite extends Produit
{

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frites')]
    private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
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
            $menu->addFrite($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeFrite($this);
        }

        return $this;
    }
}
