<?php

namespace FabLabBundle\Repository;
use FabLabBundle\Entity\Adhesion;
use \DateTime;

/**
 * AdhesionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdhesionRepository extends \Doctrine\ORM\EntityRepository
{
    function add($adherent_no, $date, $type){
        $em = $this->getEntityManager();
        $adherent = $em->getRepository('FabLabBundle:Adherent')->findOneByNo($adherent_no);
        $adhesion = new Adhesion();
        $adhesion->date = new Datetime($date);
        if($adherent->type == 0){
            $type = 0;
        }
        $adhesion->type = $type;
        if($type == 0){
            $adhesion->price = 100;
            $adhesion->cf = 32;
        } else if($type == 1){
            $adhesion->price = 30;
            $adhesion->cf = 16;
        } else {
            $adhesion->price = 15;
            $adhesion->cf = 16;
        }
        $adhesion->adherent = $adherent;
        $adherent->end_adhesion = new Datetime($adhesion->date->format('Y-m-d'));
        $adherent->end_adhesion->modify("+1 year");
        $em->persist($adhesion);
        $em->persist($adherent);
        $em->flush();
        $em->getRepository('FabLabBundle:Adherent')->update_cf($adherent_no);
    }

    function getAllForAdherent($adherentId){
        $query = $this->createQueryBuilder('p')
            ->where('p.adherent = :adherent')
            ->setParameter('adherent', $adherentId)
            ->getQuery();

        return $query->getResult();
    }
}
