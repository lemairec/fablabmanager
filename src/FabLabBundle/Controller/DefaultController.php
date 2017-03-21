<?php

namespace FabLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FabLabBundle\Entity\Adherent;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('FabLabBundle:Default:index.html.twig');
    }


    /**
     * @Route("/adherents")
     */
    public function adherentsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $adherents = $em->getRepository('FabLabBundle:Adherent')->findAll();

        return $this->render('FabLabBundle:Default:adherents.html.twig', array(
            'adherents' => $adherents,
        ));


    }

    /**
     * @Route("/produits")
     */
    public function produitsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('FabLabBundle:Produit')->findAll();

        return $this->render('FabLabBundle:Default:produits.html.twig', array(
            'produits' => $produits,
        ));
    }

    /**
     * @Route("/adherent/edit/{adherent_no}")
     */
    public function adherentEditAction($adherent_no)
    {
        $em = $this->getDoctrine()->getManager();
        $adherent = $em->getRepository('FabLabBundle:Adherent')->findOneByNo($adherent_no);
        $adhesions = $em->getRepository('FabLabBundle:Adhesion')->getAllForAdherent($adherent_no);
        return $this->render('FabLabBundle:Default:adherent_edit.html.twig', array(
            'adherent' => $adherent,
            'adhesions' => $adhesions
        ));
    }

    /**
     * @Route("/init")
     */
    public function initAction()
    {
        return $this->redirectToRoute('homepage');
    }
}
