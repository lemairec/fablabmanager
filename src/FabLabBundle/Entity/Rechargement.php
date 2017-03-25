<?php

namespace FabLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rechargement
 *
 * @ORM\Table(name="rechargement")
 * @ORM\Entity(repositoryClass="FabLabBundle\Repository\RechargementRepository")
 */
class Rechargement
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
     * @ORM\Column(name="cf", type="float")
     */
    public $cf;

    /**
     * @ORM\ManyToOne(targetEntity="FabLabBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     */
    public $adherent;

    function getDateStr(){
        return $this->date->format(' d/m/Y'); // for example
    }
}

