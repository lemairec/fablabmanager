<?php

namespace FabLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FactureFournisseur
 *
 * @ORM\Table(name="facture_fournisseur")
 * @ORM\Entity(repositoryClass="FabLabBundle\Repository\FactureFournisseurRepository")
 */
class FactureFournisseur
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_payement", type="date", nullable=true)
     */
    public $datePayement;

    /**
     * @var string
     *
     * @ORM\Column(name="pdf", type="blob")
     */
    public $pdf;
}

