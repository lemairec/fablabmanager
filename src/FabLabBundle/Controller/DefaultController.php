<?php

namespace FabLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FabLabBundle\Entity\Adherent;
use FabLabBundle\Entity\Produit;
use FabLabBundle\Form\ProduitType;

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
     * @Route("/produit/edit/{edit_id}")
     */
    public function produitsEditAction($edit_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($edit_id == 0){
            $produit = new Produit();
        } else {
            $produit = $em->getRepository('FabLabBundle:Produit')->findOneById($edit_id);
        }
        $produit->date = new \Datetime();

        $form = $this->get('form.factory')->create(ProduitType::class, $produit);
        $form->handleRequest($request);


        if ($form->isValid()) {
            if($produit->id == 0){
                return $this->redirectToRoute('produits');
            }
            $em->persist($produit);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            return $this->redirectToRoute('produits');
        }
        return $this->render('FabLabBundle:Default:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/produits", name="produits")
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
        $achats = $em->getRepository('FabLabBundle:Achat')->getAllForAdherent($adherent_no);
        return $this->render('FabLabBundle:Default:adherent_edit.html.twig', array(
            'adherent' => $adherent,
            'adhesions' => $adhesions,
            'achats' => $achats
        ));
    }

    /**
     * @Route("/adherent/edit")
     */
    public function adherentNewAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            echo($request->request->get('inputNo'));
            echo(var_dump($request->request));
            #return $this->redirectToRoute('homepage');
        }
        $em = $this->getDoctrine()->getManager();
        $adherent = new Adherent();
        return $this->render('FabLabBundle:Default:adherent_edit.html.twig', array(
            'adherent' => $adherent,
            'adhesions' => [],
            'achats' => []
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
