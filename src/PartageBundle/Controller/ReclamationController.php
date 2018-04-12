<?php


namespace PartageBundle\Controller;

use ClientBundle\Entity\Promouvoir;
use ClientBundle\Form\PromouvoirType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller ;
use ClientBundle\Entity\Produit;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ClientBundle\Entity\User;
use ClientBundle\Entity\Event;
use ClientBundle\Form\EventType;
use ClientBundle\Entity\Jaim;
use ClientBundle\Entity\Lignecommande;
use Symfony\Component\Validator\Constraints\DateTime;
use  ClientBundle\Entity\Commande;
use  ClientBundle\Entity\Paiement;
use ClientBundle\Entity\Reclamation ;
use ClientBundle\Form\ReclamationType;



class ReclamationController extends Controller
{

    public function addAction(Request $request , $nom)
    {

        $R = new \PartageBundle\Entity\Reclamation();
        $Form = $this->createForm(\PartageBundle\Form\ReclamationType::class, $R);
        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {
            $R->setReclameur($this->getUser()->getUsername());
            $R->setReclamee($nom);
            $R->setDate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($R);
            $em->flush();
            $manager = $this->get('mgilet.notification');
            $guest= $this->getUser()->getUsername();

            $notif = $manager->generateNotification('Salut' .$guest);
            $notif->setMessage('Votre reclamation a été ajoué ');
            $notif->setLink('http://symfony.com/');
            $manager->addNotification($this->getUser(), $notif);
            return $this->redirectToRoute('ListFront_reclamation');
        }
        return $this->render('PartageBundle:Reclamation:add.html.twig', array("Form" => $Form->createView()

        ));
    }

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reclamations = $em->getRepository('PartageBundle:Reclamation')->findAll();
        return $this->render('PartageBundle:Reclamation:list.html.twig', array("list" => $reclamations));
    }

    public function listfrontAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reclamations = $em->getRepository('PartageBundle:Reclamation')->findAll();
        return $this->render('PartageBundle:Reclamation:listFront.html.twig', array("list" => $reclamations));
    }

    public function modifierAction(Request $request)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $rec = $em->getRepository("PartageBundle:Reclamation")->find($id);
        $Form = $this->createForm(\PartageBundle\Form\ReclamationType::class, $rec);
        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {
            $rec->setReclameur($this->getUser()->getUsername());
            $rec->setReclamee("sdsf");
            $rec->setDate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($rec);
            $em->flush();
             return $this->redirectToRoute('ListFront_reclamation');
        }
        return $this->render('PartageBundle:Reclamation:update.html.twig', array("Form" => $Form->createView()

        ));
    }
    public function detailAction( Request $request)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $rec = $em->getRepository('PartageBundle:Reclamation')->find($id);
        return $this->render('PartageBundle:Reclamation:detail.html.twig', array("rec" => $rec));
    }


    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rec = $em->getRepository('PartageBundle:Reclamation')->find($id);
        $em->remove($rec);
        $em->flush();
        return $this->redirectToRoute("list_reclamation");
    }

    public function supprimerfrontAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rec = $em->getRepository('PartageBundle:Reclamation')->find($id);
        $em->remove($rec);
        $em->flush();
        return $this->redirectToRoute("ListFront_reclamation");
    }

    public function searchAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $rec = $em->getRepository("PartageBundle:Reclamation")
            ->findAll();


        if ($request->isMethod("POST")) {
            //echo "suite au click";
            $filter = $request->get("reclameur");

            $rec = $em->getRepository("PartageBundle:Reclamation")
                ->findBy(
                    array(
                        "reclameur" => $filter
                    )
                );

            //$rec = $em->getRepository("PartageBundle:Reclamation")
              //  ->findReclamation($filter);
        }


        return $this->render("PartageBundle:Reclamation:search.html.twig",
            array(
                "Reclamation" => $rec
            )
        );
    }


}