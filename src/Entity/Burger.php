<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    normalizationContext :['groups' => ['liste-simple','liste-all']],
    denormalizationContext:['groups' => ['liste-simple', 'liste-all']],
    collectionOperations:[
        "get"=>[
            'method' => 'get',
            'status' => Response::HTTP_OK,
            // 'normalization_context' => ['groups' => ['liste-simple']],
        ] ,
        "post"=>[
            // 'denormalization_context' => ['groups' => ['liste-simple','liste-all']],
            // 'normalization_context' => ['groups' => ['liste-all']]
        ]],
    itemOperations:[
        "put"=>[
            "security"=> "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=> "Vous n'avez pas accès à cette Ressource",
        ],
        "get"=>[
            'method' => 'get',
            'status' => Response::HTTP_OK,
            // 'normalization_context' => ['groups' => ['liste-all']],
        ],
        ])]
class Burger extends Produit
{
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'burgers')]
    private $menus;

    public function __construct()
    {
        parent::__construct();
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
            $menu->addBurger($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeBurger($this);
        }

        return $this;
    }
}
