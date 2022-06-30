<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonRepository;
use App\Repository\FriteRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ApiResource(
    collectionOperations:["get"],
    itemOperations:[]
)]
class Complement
{
    private int $id;
    private  $frites;
    private $boissons;

    public function __construct()
    {
        $this->frites = new ArrayCollection();
        $this->boissons = new ArrayCollection();
    }

    /**
     * Get the value of frites
     */ 
    public function getFrites()
    {
        return $this->frites;
    }

    /**
     * Set the value of frites
     *
     * @return  self
     */ 
    public function setFrites($frites)
    {
        $this->frites = $frites;

        return $this;
    }

    /**
     * Get the value of boissons
     */ 
    public function getBoissons()
    {
        return $this->boissons;
    }

    /**
     * Set the value of boissons
     *
     * @return  self
     */ 
    public function setBoissons($boissons)
    {
        $this->boissons = $boissons;

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
