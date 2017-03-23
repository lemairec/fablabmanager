<?php

namespace FabLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FabLabBundle\Entity\Adherent;
use FabLabBundle\Entity\Produit;
use FabLabBundle\Entity\Achat;
use FabLabBundle\Form\ProduitType;
use FabLabBundle\Form\AchatType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nb_adherents = $em->getRepository('FabLabBundle:Adherent')->getNb();
        return $this->render('FabLabBundle:Default:index.html.twig', array(
            'nb_adherents' => $nb_adherents
        ));
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
     * @Route("/achat/edit/{achat_id}")
     */
    public function achatEditAction($achat_id, Request $request)
    {
        $adherent_no = intval($request->query->get('adherent_no'));
        $em = $this->getDoctrine()->getManager();
        if($achat_id == 0){
            $achat = new Achat();
            $achat->date = new \Datetime();
            $achat->adherent = $em->getRepository("FabLabBundle:Adherent")->findOneByNo($adherent_no);
        } else {
            $achat = $em->getRepository('FabLabBundle:Achat')->findOneById($achat_id);
        }
        $form = $this->createForm(AchatType::class, $achat, array(
            'categorie' => $achat->adherent->price_categorie
        ));
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em->persist($achat);
            $em->flush();
            $em->getRepository("FabLabBundle:Adherent")->update_cf($adherent_no);
            return $this->redirectToRoute('adherent', array('adherent_no' => $adherent_no));
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
     * @Route("/adherent/edit/{adherent_no}", name="adherent")
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
