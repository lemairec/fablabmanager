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
        $adherentsRepository = $this->getDoctrine()->getManager()->getRepository('FabLabBundle:Adherent');
        $adhesionRepository = $this->getDoctrine()->getManager()->getRepository('FabLabBundle:Adhesion');
        $adherent = $adherentsRepository->add("Clément", "Lemaire", 1);
        $adhesionRepository->add($adherent->id, "2010-01-01", 1);
        $adherent = $adherentsRepository->add("-", "NTN", 0);
        $adhesionRepository->add($adherent->id, "2010-01-03", 1);
        return $this->redirectToRoute('homepage');
    }
}
