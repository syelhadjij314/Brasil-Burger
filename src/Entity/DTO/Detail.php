<?php
namespace App\Entity\DTO;

use App\Entity\Menu;
use App\Entity\Burger;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext :['groups' => ['detail:read']],
    collectionOperations:[],
    itemOperations: [
        "get"=>[
            "method" => "get",
            "status" => Response::HTTP_OK,
        ]
    ]
)]
class Detail
{
    #[Groups(["detail:read"])]
    public ?int $id;
  
    #[Groups(["detail:read"])]
    private Menu|Burger $produit;
    #[Groups(["detail:read"])]
    private $boissons;
    #[Groups(["detail:read"])]
    private $frites;
    
    public function __construct()
    {        
        $this ->boissons = new ArrayCollection();
        $this ->frites = new ArrayCollection();    
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * Get the value of produit
     */ 
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set the value of produit
     *
     * @return  self
     */ 
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }
}
