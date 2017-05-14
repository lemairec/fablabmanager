<?php

namespace FabLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="FabLabBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    public $id;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    public $name;

    /**
     * @var int
     *
     * @ORM\Column(name="categorie", type="string", length=1)
     */
    public $categorie;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    public $price;

    /**
     * @var string
     *
     * @ORM\Column(name="unite", type="string", length=255)
     */
    public $unite;

    public function getLabel(){
        return $this->categorie." ".$this->name;
    }
}

