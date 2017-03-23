<?php

namespace FabLabBundle\Repository;
use FabLabBundle\Entity\Achat;
use \DateTime;

/**
 * AchatRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AchatRepository extends \Doctrine\ORM\EntityRepository
{
    function add($adherent_no, $produit_id, $date, $qty){
        $em = $this->getEntityManager();
        $adherent = $em->getRepository('FabLabBundle:Adherent')->findOneByNo($adherent_no);
        $produit = $em->getRepository('FabLabBundle:Produit')->findOneById($produit_id);
        $achat = new Achat();
        $achat->adherent = $adherent;
        $achat->produit = $produit;
        $achat->date = new Datetime($date);
        $achat->setQty($qty);
        $em->persist($achat);
        $adherent->cf = $adherent->cf - $achat->price;
        $em->persist($adherent);
        $em->flush();
        $em->getRepository('FabLabBundle:Adherent')->update_cf($adherent_no);
        return $achat;

    }
    function getAllForAdherent($adherent_no){
        $query = $this->createQueryBuilder('p')
            ->where('p.adherent = :adherent')
            ->setParameter('adherent', $adherent_no)
            ->getQuery();

        return $query->getResult();
    }
}