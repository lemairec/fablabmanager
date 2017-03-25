<?php

namespace FabLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Achat
 *
 * @ORM\Table(name="achat")
 * @ORM\Entity(repositoryClass="FabLabBundle\Repository\AchatRepository")
 */
class Achat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    public $date;

    /**
     * @var float
     *
     * @ORM\Column(name="qty", type="float")
     */
    public $qty;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255)
     */
    public $price;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptif", type="string", length=255, nullable=true)
     */
    public $descriptif;


    /**
     * @ORM\ManyToOne(targetEntity="FabLabBundle\Entity\Produit")
     * @ORM\JoinColumn(nullable=false)
     */
    public $produit;

    /**
     * @ORM\ManyToOne(targetEntity="FabLabBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     */
    public $adherent;

    public function setQty($qty){
        $this->qty = $qty;
        if($this->produit->name == "decoupeuse-laser"){
            if($qty>5){
                $this->price = 5 + ($qty-5)*0.25;
            } else {
                $this->price = $qty*1;
            }
        } else {
            $this->price = $qty * $this->produit->price;
        }
    }
    
    function getDateStr(){
        return $this->date->format(' d/m/Y'); // for example
    }

}
