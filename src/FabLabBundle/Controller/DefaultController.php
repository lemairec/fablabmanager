<?php

namespace FabLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FabLabBundle\Entity\Adherent;
use FabLabBundle\Entity\Produit;
use FabLabBundle\Entity\Achat;
use FabLabBundle\Entity\Adhesion;
use FabLabBundle\Entity\Rechargement;
use FabLabBundle\Form\ProduitType;
use FabLabBundle\Form\AchatType;
use FabLabBundle\Form\AdhesionType;
use FabLabBundle\Form\AdherentType;
use FabLabBundle\Form\RechargementType;

use Datetime;
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
     * @Route("/adhesion/edit/{adhesion_id}")
     */
    public function adhesionEditAction($adhesion_id, Request $request)
    {
        $adherent_no = intval($request->query->get('adherent_no'));
        $em = $this->getDoctrine()->getManager();
        if($adhesion_id == 0){
            $adhesion = new Adhesion();
            $adhesion->date = new \Datetime();
            $adhesion->adherent = $em->getRepository("FabLabBundle:Adherent")->findOneByNo($adherent_no);
        } else {
            $adhesion = $em->getRepository('FabLabBundle:Adhesion')->findOneById($adhesion_id);
        }
        $form = $this->createForm(AdhesionType::class, $adhesion, array(
            'categorie' => $adhesion->adherent->price_categorie
        ));
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em->getRepository("FabLabBundle:Adhesion")->save($adhesion);
            return $this->redirectToRoute('adherent', array('adherent_no' => $adherent_no));
        }
        return $this->render('FabLabBundle:Default:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/rechargement/edit/{rechargement_id}")
     */
    public function rechargementEditAction($rechargement_id, Request $request)
    {
        $adherent_no = intval($request->query->get('adherent_no'));
        $em = $this->getDoctrine()->getManager();
        if($rechargement_id == 0){
            $rechargement = new Rechargement();
            $rechargement->date = new \Datetime();
            $rechargement->adherent = $em->getRepository("FabLabBundle:Adherent")->findOneByNo($adherent_no);
        } else {
            $rechargement = $em->getRepository('FabLabBundle:Rechargement')->findOneById($rechargement_id);
        }
        $form = $this->createForm(RechargementType::class, $rechargement);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em->persist($rechargement);
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
    public function adherentEditAction($adherent_no, Request $request)
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
        $adhesions = $em->getRepository('FabLabBundle:Adhesion')->getAllForAdherent($adherent_no);
        $achats = $em->getRepository('FabLabBundle:Achat')->getAllForAdherent($adherent_no);
        $rechargements = $em->getRepository('FabLabBundle:Rechargement')->getAllForAdherent($adherent_no);
        return $this->render('FabLabBundle:Default:adherent_edit.html.twig', array(
            'form' => $form->createView(),
            'adherent' => $adherent,
            'adhesions' => $adhesions,
            'achats' => $achats,
            'rechargements' => $rechargements
        ));
    }

    /**
     * @Route("/init")
     */
    public function initAction()
    {
        return $this->redirectToRoute('homepage');
    }
    
    /**
     * @Route("/api/stat_adherents")
     */
    public function staAdherentsApi()
    {
        $em = $this->getDoctrine()->getManager();
        $adherents = $em->getRepository('FabLabBundle:Adherent')->findAll();
        $now = new Datetime();
        $res = [0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0];
        foreach($adherents as $a){
            if($a->birthday){
                $age = date_diff($a->birthday, $now)->y;
                $age = ($age-$age%10)/10;
                if(!array_key_exists($age, $res)){
                    $res[$age] = 0;
                }
                $res[$age] += 1;
            }
        }
        #echo(var_dump($res));
        $res2 = [];
        foreach($res as $k=>$value){
            $res2[] = ["letter"=>($k*10).'-'.($k*10+9), "frequency"=>$value];
        }
        #$res = [["letter"=>"A","frequency"=>0.08167]];
        $response = new Response(json_encode($res2));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
}
}
