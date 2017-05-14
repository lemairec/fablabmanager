<?php

namespace FabLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FournisseurController extends Controller
{
    /**
     * @Route("/fournisseurs", name="fournisseurs")
     */
    public function fournisseursAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fournisseurs = $em->getRepository('FabLabBundle:Fournisseur')->findAll();
        return $this->render('FabLabBundle:Fournisseur:fournisseurs.html.twig', array(
            'fournisseurs' => $fournisseurs,
        ));

    }
}
