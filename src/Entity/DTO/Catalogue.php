<?php
namespace App\Entity\DTO;

use App\Repository\CatalogueRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations:[
        "get"=>[
            "method"=> "get",
            "path" => "/catalogues",
            "status" => Response::HTTP_OK,
            "normalization_context"=>["groups"=>["catalogue:red"]]
        ],
    ],
)]
class Catalogue
{
    // private int $id;
    #[Groups(['catalogue:read'])]
    private array $burgers;

    #[Groups(['catalogue:read'])]
    private array $menus;

    public function __construct()
    {
        $this ->burgers = new ArrayCollection();
        $this ->menus = new ArrayCollection();
    }

    /**
     * Get the value of burgers
     */ 
    public function getBurgers()
    {
        return $this->burgers;
    }

    /**
     * Set the value of burgers
     *
     * @return  self
     */ 
    public function setBurgers($burgers)
    {
        $this->burgers = $burgers;

        return $this;
    }

    /**
     * Get the value of menus
     */ 
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Set the value of menus
     *
     * @return  self
     */ 
    public function setMenus($menus)
    {
        $this->menus = $menus;

        return $this;
    }

}
