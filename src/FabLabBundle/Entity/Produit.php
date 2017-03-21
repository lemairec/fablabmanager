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
     * @ORM\Column(name="description", type="string", length=255)
     */
    public $description;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    public $type;

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
}

