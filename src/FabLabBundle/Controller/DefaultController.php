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
     * @Route("/adherent/edit")
     */
    public function adherentEditAction()
    {
        $em = $this->getDoctrine()->getManager();
    }

    /**
     * @Route("/init")
     */
    public function initAction()
    {
        $em = $this->getDoctrine()->getManager();
        $adherent = new Adherent("lemaire", "clément");
        $em->persist($adherent);
        $em->flush();
        return $this->redirectToRoute('homepage');
    }
}
