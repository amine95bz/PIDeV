<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\Produit;
use ProduitBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProduitBundle:Default:index.html.twig');
    }

    public function valideAction()
    {
        return $this->render('ProduitBundle:Default:valide.html.twig');
    }

    public function validePAction()
    {
        return $this->render('ProduitBundle:Default:succes.html.twig');
    }

//Ajouter Produit
    public function addAction(Request $request)
    {
        $Produit = new Produit();
        $form=$this->createForm(ProduitType::class,$Produit);
        $form->handleRequest($request);
        $Produit->setProp($this->getUser());
        if ($form->isValid()) { // suite au clic sur le bouton

        $file = $Produit->getImg();
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $Produit->setImg($fileName);
        $file->move(
            $this->getParameter('user_directory'),
            $fileName
        );
//        $Produit = new Produit();
//        $form = $this->createForm(ProduitType::class, $Produit);
//        $form->handleRequest($request);
//        $Produit->setProp($this->getUser());
//
//        if ($form->isValid()) { // suite au clic sur le bouton
//
//            $dir="C:\\wamp64\\www\\medina1\\web\\ProduitImages";
//            $file=$form['img']->getData();
//            $Produit->setImg($Produit->getNomp().".png,.jpg,.gif");
//            $file->move($dir,$Produit->getImg());
            $Produit->setProp($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($Produit);
            $em->flush();
            return $this->redirectToRoute('succes');

        }
        return $this->render('ProduitBundle:Default:ajout_Produit.html.twig', array(

            "Form" => $form->createView()
        ));
    }




//Lister les produits
    public function ProduitsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $produit = $em
            ->getRepository('ProduitBundle:Produit')->findBy(array("prop"=>$user));


        $paginator = $this->get('knp_paginator');
        $produit = $paginator->paginate(
            $produit,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)
        );
        return $this->render('ProduitBundle:Default:tout_Produit.html.twig', array(
            'produits' => $produit
//            'okk' => $okk
        ));

    }

//Affichage des produits
    public function afficherProduitAction(Request $request){

        $produit = $this->getDoctrine()->getManager();
        $produits= $produit->getRepository("ProduitBundle:Produit")->findAll();
        $paginator = $this->get('knp_paginator');
        $produits=$paginator->paginate($produits,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 4)
            );
        return $this->render('ProduitBundle:Default:afficher.html.twig',array(
            'produit'=>$produits
        ));

    }


    //////pdf
    public function pdfProdAction(){
        $produit = $this->getDoctrine()->getManager();
        $produits= $produit->getRepository("ProduitBundle:Produit")->findAll();
        $snappy = $this->get('knp_snappy.pdf');
        $html = $this->render('ProduitBundle:Default:pdf.html.twig',array(
            'produits'=>$produits
        ));

        $filename = 'MesProduits';
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }
//Paeiment
    public function paymentAction(Request $request) //Request container lel http fondation
    {
        \Stripe\Stripe::setApiKey("sk_test_EDZGlNOLUBIbivwd6lmHJNL4");

//        \Stripe\Charge::create(array(
//            "amount" => 1000,
//            "currency" => "usd",
//            "source" => $request->request->get('stripeToken'), // obtained with Stripe.js
//            "description" => "TEST"
//        return $this->redirectToRoute('succes');
//        ));
        return $this->render('ProduitBundle:Default:payment.html.twig');

    }

//Supprimer produit
    public function supAction($ref)
    {

        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("ProduitBundle:Produit")->find($ref);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('tout_produit');

    }

    public function supAdminAction($ref)
    {

        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("ProduitBundle:Produit")->find($ref);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('Adminaff');

    }

//Modifier produit
    public function modifierProduitAction(Request $request, $ref)
    {
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository("ProduitBundle:Produit")->find($ref);
        $form=$this->createForm(ProduitType::class,$produit);
        $form->handleRequest($request);
        $produit->setProp($this->getUser());


            if ($form->isValid()){
                $em=$this->getDoctrine()->getManager();
                $em->persist($produit);
                $em->flush();
                return $this->redirectToRoute('succes');

            }
            return $this->render('ProduitBundle:Default:modif.html.twig',array("Form"=>$form->createView()));
    }

//Detailer produit
    public function detailProdAction(Request $request)
    {

        $id=$request->get("ref");
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository("ProduitBundle:Produit")->find($id);
        $idu=$produit->getProp();
        $nom=$produit->getNomp();
        $image=$produit->getImg();
        $description=$produit->getDescrip();
        $type=$produit->getType();


        return $this->render('ProduitBundle:Default:detailProd.html.twig', array(

            'nom' => $nom,
            'type'=> $type,
            'image' => $image,
            'desc' => $description,
            'produit' => $produit));

    }


//Affichage selon les catégories
    /**
     * @return Response
     */
    public function vetementAction()
    {
        $produit = new Produit();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ProduitBundle:Produit")->findAll();
        $query = $em->createQuery('SELECT p 
                                FROM ProduitBundle:Produit p
                                WHERE p.type =:h');
        $query->setParameter('h',"Vetement");
        $produits=$query->getResult();
        return $this->render('ProduitBundle:Default:vetement.html.twig',array('produit'=>$produits));
    }

    public function accessoireAction()
    {
        $produit = new Produit();
        $em = $this->getDoctrine()->getManager();
        $produits= $em->getRepository("ProduitBundle:Produit")->findAll();
        $query =$em->createQuery ('SELECT p
                                FROM ProduitBundle:Produit p 
                                WHERE p.type =:h');
        $query->setParameter('h','Accessoire');
        $produits=$query->getResult();
        return $this->render('ProduitBundle:Default:accessoire.html.twig',array('produit'=>$produits));

    }

    public function alimentAction()
    {
        $produit = new Produit();
        $em = $this->getDoctrine()->getManager();
        $produits= $em->getRepository("ProduitBundle:Produit")->findAll();
        $query =$em->createQuery ('SELECT p
                                FROM ProduitBundle:Produit p 
                                WHERE p.type =:h');
        $query->setParameter('h','Aliment');
        $produits=$query->getResult();
        return $this->render('ProduitBundle:Default:aliment.html.twig',array('produit'=>$produits));

    }


    public function otherAction()
    {
        $produit = new Produit();
        $em = $this->getDoctrine()->getManager();
        $produits= $em->getRepository("ProduitBundle:Produit")->findAll();
        $query =$em->createQuery ('SELECT p
                                FROM ProduitBundle:Produit p 
                                WHERE p.type =:h');
        $query->setParameter('h','Autre');
        $produits=$query->getResult();
        return $this->render('ProduitBundle:Default:autre.html.twig',array(
            'produit'=>$produits
        ));

    }



    public function adminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $produit = $em
            ->getRepository('ProduitBundle:Produit')->findAll();


        $paginator = $this->get('knp_paginator');
        $produit = $paginator->paginate(
            $produit,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );
        return $this->render('ProduitBundle:Default:admin.html.twig', array(
            'produits' => $produit
//            'okk' => $okk
        ));

    }








}
