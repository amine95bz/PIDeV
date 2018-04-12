<?php

namespace PartageBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller ;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BaseBundle\Entity\User;

use Symfony\Component\Validator\Constraints\DateTime;

use PartageBundle\Entity\Commentaire ;
use PartageBundle\Form\CommentaireType;

class CommentaireController extends Controller
{

    public function addAction(Request $request)
    {

        $com=new Commentaire();

        $form=$this->createForm(CommentaireType::class,$com);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){
            $com->setUser($this->getUser()->getUsername());
            $com->setDate(new \DateTime());
            $em = $this->getDoctrine()->getManager();

            $em->persist($com);
            $em->flush();



            return $this->redirectToRoute("list_commentaire");
        }


        return $this->render('PartageBundle:Commentaire:add.html.twig', array("Form"=>$form->createView()


        ));
    }

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commentaires = $em->getRepository('PartageBundle:Commentaire')->findAll();
        return $this->render('PartageBundle:Commentaire:list.html.twig', array("list" => $commentaires));
    }

    public function modifierAction(Request $request)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $com = $em->getRepository("PartageBundle:Commentaire")->find($id);
        $Form = $this->createForm(\PartageBundle\Form\CommentaireType::class, $com);
        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {
            $com->setUser($this->getUser()->getUsername());
            //$rec->setReclamee("sdsf");
            $com->setDate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($com);
            $em->flush();
            return $this->redirectToRoute("list_commentaire");

        }
        return $this->render('PartageBundle:Commentaire:update.html.twig', array("Form" => $Form->createView()

        ));
    }

    public function detailAction( Request $request)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $com = $em->getRepository('PartageBundle:Commentaire')->find($id);
        return $this->render('PartageBundle:Commentaire:detail.html.twig', array("com" => $com));
    }


    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $com = $em->getRepository('PartageBundle:Commentaire')->find($id);
        $em->remove($com);
        $em->flush();
        return $this->redirectToRoute("list_commentaire");

    }

    public function searchAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $com = $em->getRepository("PartageBundle:Commentaire")
            ->findAll();


        if ($request->isMethod("POST")) {
            //echo "suite au click";
            $filter = $request->get("contenu");

            $com = $em->getRepository("PartageBundle:Commentaire")
                ->findBy(
                    array(
                        "contenu" => $filter
                    )
                );

            //$rec = $em->getRepository("PartageBundle:Reclamation")
            //  ->findReclamation($filter);
        }


        return $this->render("PartageBundle:Commentaire:search.html.twig",
            array(
                "Commentaire" => $com
            )
        );
    }
    public function affichagebackAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commentaires = $em->getRepository('PartageBundle:Commentaire')->findAll();
        return $this->render('PartageBundle:Commentaire:affichageback.html.twig', array("list" => $commentaires));
    }
    public function supprimerbackAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $com = $em->getRepository('PartageBundle:Commentaire')->find($id);
        $em->remove($com);
        $em->flush();
        return $this->redirectToRoute("affichageback");

    }




}
