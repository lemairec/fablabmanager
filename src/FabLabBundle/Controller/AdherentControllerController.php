<?php

namespace FabLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FabLabBundle\Entity\Adherent;
use FabLabBundle\Form\AdherentType;

class AdherentControllerController extends Controller
{
    /**
     * @Route("/adherent/{adherent_no}/edit", name="adherent_edit")
     */
    public function adherentEdit2Action($adherent_no, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($adherent_no == 0){
            $adherent = new Adherent();
        } else {
            $adherent = $em->getRepository('FabLabBundle:Adherent')->findOneByNo($adherent_no);
        }
        $form = $this->createForm(AdherentType::class, $adherent);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em->getRepository('FabLabBundle:Adherent')->save($adherent);
            return $this->redirectToRoute('adherent', array('adherent_no' => $adherent_no));
        }
    
        $em = $this->getDoctrine()->getManager();
        return $this->render('FabLabBundle:Adherent:edit.html.twig', array(
            'form' => $form->createView(),
            'adherent' => $adherent,
            'route' => "edit"
        ));
    
    }
    /**
     * @Route("/adherent/{adherent_no}", name="adherent")
     */
    public function adherentAdherentAction($adherent_no, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($adherent_no == 0){
            return $this->redirectToRoute('adherent_edit', array('adherent_no' => $adherent_no));
        } else {
            $adherent = $em->getRepository('FabLabBundle:Adherent')->findOneByNo($adherent_no);
        }
        return $this->render('FabLabBundle:Adherent:adherent.html.twig', array(
            'adherent' => $adherent,
            'route' => ""
        ));
    }
   

    /**
     * @Route("/adherent/{adherent_no}/adhesions", name="adherent_adhesions")
     */
    public function adherentAdhesionsAction($adherent_no, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($adherent_no == 0){
            return $this->redirectToRoute('adherent_edit', array('adherent_no' => $adherent_no));
        } else {
            $adherent = $em->getRepository('FabLabBundle:Adherent')->findOneByNo($adherent_no);
        }
        $adhesions = $em->getRepository('FabLabBundle:Adhesion')->getAllForAdherent($adherent_no);
        return $this->render('FabLabBundle:Adherent:adhesions.html.twig', array(
            'adherent' => $adherent,
            'adhesions' => $adhesions,
            'route' => "adhesions"
        ));
    }
   
    /**
     * @Route("/adherent/{adherent_no}/achats", name="adherent_achats")
     */
    public function adherentAchatsAction($adherent_no, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($adherent_no == 0){
            return $this->redirectToRoute('adherent_edit', array('adherent_no' => $adherent_no));
        } else {
            $adherent = $em->getRepository('FabLabBundle:Adherent')->findOneByNo($adherent_no);
        }
        $achats = $em->getRepository('FabLabBundle:Achat')->getAllForAdherent($adherent_no);
        return $this->render('FabLabBundle:Adherent:achats.html.twig', array(
            'adherent' => $adherent,
            'achats' => $achats,
            'route' => "achats"
        ));
    }

     /**
     * @Route("/adherent/{adherent_no}/rechargements", name="adherent_rechargements")
     */
    public function adherentRechargementAction($adherent_no, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($adherent_no == 0){
            return $this->redirectToRoute('adherent_edit', array('adherent_no' => $adherent_no));
        } else {
            $adherent = $em->getRepository('FabLabBundle:Adherent')->findOneByNo($adherent_no);
        }
        $rechargements = $em->getRepository('FabLabBundle:Rechargement')->getAllForAdherent($adherent_no);
        return $this->render('FabLabBundle:Adherent:rechargements.html.twig', array(
            'adherent' => $adherent,
            'rechargements' => $rechargements,
            'route' => "rechargements"
        ));
 
    }
   
    /**
     * @Route("/adherent/{adherent_no}/factures", name="adherent_factures")
     */
    public function adherentFactureAction($adherent_no, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($adherent_no == 0){
            return $this->redirectToRoute('adherent_edit', array('adherent_no' => $adherent_no));
        } else {
            $adherent = $em->getRepository('FabLabBundle:Adherent')->findOneByNo($adherent_no);
        }
        return $this->render('FabLabBundle:Adherent:factures.html.twig', array(
            'adherent' => $adherent,
            'factures' => [],
            'route' => "factures"
        ));
 
    }

}
