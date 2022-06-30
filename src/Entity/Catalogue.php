<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\CatalogueRepository;

#[ApiResource(
    collectionOperations:["get"],
    itemOperations:[]
)]
class Catalogue
{
    // private int $id;
    private array $burgers;
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

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
