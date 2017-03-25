<?php

namespace FabLabBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @ORM\Column(name="name", type="string", length=255)
     */
    public $name;

    /**
     * @var string
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    public $surname;

    /**
     * @var string
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    public $adresse;

    /**
     * @var string
     * @ORM\Column(name="code_postal", type="string", length=5, nullable=true)
     */
    public $code_postal;
    
    /**
     * @var string
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    public $city;

    /**
     * @var \Datetime 
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    public $birthday;
    
    /**
     * @var string
     * @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     */
    public $sexe;
    
    /**
     * @var string
     * @ORM\Column(name="activite", type="string", length=255, nullable=true)
     */
    public $activite;
    
    /**
     * @var string
     * @ORM\Column(name="mail", type="string", length=255, nullable=true)
     */
    public $mail;
    
    /**
     * @var bool
     * @ORM\Column(name="fondateur", type="boolean")
     */
    public $fondateur;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    public $type;
    
    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="string", length=255)
     */
    public $remarque;
    

    /**
     * @var int
     *
     * @ORM\Column(name="price_categorie", type="string", length=1)
     */
    public $price_categorie;



    /**
     * @var bool
     * @ORM\Column(name="actif", type="boolean", unique=false)
     */
    public $actif;

    /**
     * @var bool
     * @ORM\Column(name="bureau", type="boolean")
     */
    public $bureau;

    /**
     * @var bool
     * @ORM\Column(name="lettre_info", type="boolean")
     */
    public $lettre_info;

    /**
     * @var \Datetime 
     * @ORM\Column(name="end_adhesion", type="date", nullable=true)
     */
    public $end_adhesion;

    /**
     * @var float
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
