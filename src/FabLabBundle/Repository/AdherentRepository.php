<?php

namespace FabLabBundle\Repository;
use FabLabBundle\Entity\Adherent;

/**
 * AdherentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdherentRepository extends \Doctrine\ORM\EntityRepository
{
    function add($no, $name, $surname, $type){
        $em = $this->getEntityManager();
        $adherent = new Adherent($name, $surname, $type);
        $adherent->no = $no;
        $em->persist($adherent);
        $em->flush();
        return $adherent;
    }

}

