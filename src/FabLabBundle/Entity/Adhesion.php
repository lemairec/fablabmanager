<?php

namespace FabLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adhesion
 *
 * @ORM\Table(name="adhesion")
 * @ORM\Entity(repositoryClass="FabLabBundle\Repository\AdhesionRepository")
 */
class Adhesion
{
    /**
     * @var guid 
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="FabLabBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     */
    public $adherent;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    public $date;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    public $type;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    public $price;

    /**
     * @var int
     *
     * @ORM\Column(name="cf", type="integer")
     */
    public $cf;


    function getDateStr(){
        return $this->date->format(' d/m/Y'); // for example
    }
}

