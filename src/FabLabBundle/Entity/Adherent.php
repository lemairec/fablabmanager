<?php

namespace FabLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adherent
 *
 * @ORM\Table(name="adherent")
 * @ORM\Entity(repositoryClass="FabLabBundle\Repository\AdherentRepository")
 */
class Adherent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    public $no;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    public $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    public $surname;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", unique=false)
     */
    public $type;
    
    /**
     * @var int
     *
     * @ORM\Column(name="price_categorie", type="string", length=1)
     */
    public $price_categorie;



    /**
     * @var bool
     *
     * @ORM\Column(name="actif", type="boolean", unique=false)
     */
    public $actif;

    /**
     * @var \Datetime 
     *
     * @ORM\Column(name="end_adhesion", type="date", nullable=true)
     */
    public $end_adhesion;

    /**
     * @var float
     *
     * @ORM\Column(name="cf", type="float")
     */
    public $cf;

    function get_end_adhesion(){
        if($this->end_adhesion== NULL){
            return "";
        } else {
            return $this->end_adhesion->format(' d/m/Y'); // for example
        }
    }
}
