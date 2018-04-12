<?php

namespace LocalBundle\Controller;

use LocalBundle\Entity\Annonce;
use LocalBundle\Entity\Local;
use LocalBundle\Entity\Rating;
use LocalBundle\Form\AnnonceType;
use LocalBundle\Form\LocalType;
use LocalBundle\Form\RatingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LocalBundle:Default:index.html.twig');
    }

    public function succesAction()
    {
        return $this->render('LocalBundle:Default:succes.html.twig');
    }

    public function ajoutAction(Request $request)
    {
        $local = new Local();
        $form = $this->createForm(LocalType::class, $local);
        $form->handleRequest($request);
        $local->setProp($this->getUser());


        if($request->isXmlHttpRequest()) {



                if ($form->isValid() ) { // suite au clic sur le bouton


                    $em = $this->getDoctrine()->getManager();
                    $local->setLat($request->get("deplat"));
                    $local->setLang($request->get("deplng"));
                    $em->persist($local);
                    $em->flush();
                    return $this->redirectToRoute('succes');

                }



            }



        return $this->render('LocalBundle:Default:ajout_local.html.twig', array(

            "Form" => $form->createView()

        ));

    }

    public function locauxAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $locaux = $em->getRepository("LocalBundle:Local")->findBy(array('prop' => $id));
        return $this->render('LocalBundle:Default:all_local.html.twig', array(

            "locaux" => $locaux
        ));

    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $local = $em->getRepository("LocalBundle:Local")->find($id);
        $em->remove($local);
        $em->flush();
        return $this->redirectToRoute('all_local',$this->getUser());

    }

    public function modifierAction(Request $request , $id)
    {
        $em = $this->getDoctrine()->getManager();
        $local = $em->getRepository("LocalBundle:Local")->find($id);
        $form = $this->createForm(LocalType::class, $local);
        $form->handleRequest($request);
        $local->setProp($this->getUser());

        if ($form->isValid()) { // suite au clic sur le bouton

            $em = $this->getDoctrine()->getManager();
            $em->persist($local);
            $em->flush();
            return $this->redirectToRoute('succes');

        }
        return $this->render('LocalBundle:Default:edit_local.html.twig', array(

            "Form" => $form->createView()

        ));

    }


    public function addAction(Request $request)
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        $annonce->setIdProp($this->getUser());
        $annonce->setInsertdate(new \DateTime('today') );
        $annonce->setOwner($this->getUser()->getUsername());


        if ($form->isValid()) {
            // suite au clic sur le bouton

            $file = $annonce->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $annonce->setImage($fileName);
            $file->move(
                $this->getParameter('user_directory'),
                $fileName
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('succes');

        }
        return $this->render('LocalBundle:Default:add_annonce.html.twig', array(

            "Form" => $form->createView()

        ));

    }

    public function mes_annoncesAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository("LocalBundle:Annonce")->findBy(array('id_prop' => $id));
        return $this->render('LocalBundle:Default:mes_annonces.html.twig', array(

            "annonces" => $annonces
        ));

    }



    public function edit_annonceAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("LocalBundle:Annonce")->find($id);

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        $annonce->setIdProp($this->getUser());


        if ($form->isValid()) {
            // suite au clic sur le bouton

            $file = $annonce->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $annonce->setImage($fileName);
            $file->move(
                $this->getParameter('user_directory'),
                $fileName
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('succes');

        }
        return $this->render('LocalBundle:Default:edit_annonce.html.twig', array(

            "Form" => $form->createView()

        ));

    }
    public function delete_annonceAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("LocalBundle:Annonce")->find($id);


        $em->remove($annonce);
        $em->flush();
        $manager = $this->get('mgilet.notification');
        $guest= $this->getUser()->getUsername();

        $notif = $manager->generateNotification('Salut' .$guest);
        $notif->setMessage('Votre Annonce a ete suppriméé ');
        $notif->setLink('http://symfony.com/');
        $manager->addNotification($this->getUser(), $notif);

        return $this->redirectToRoute('mes_annonces',array('id' => $this->getUser()->getId()));

    }

    public function annonce_allAction()
    {

        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository("LocalBundle:Annonce")->findAll();

        return $this->render('LocalBundle:Default:annonces_all.html.twig', array(

            "annonces" => $annonces
        ));

    }


    public function mapAction()
    {
        return $this->render('LocalBundle:Default:map.html.twig');
    }


    public function singleAction(Request $request ,$id)
    {
        $rate = new Rating();
        $okk = 0;

        $form = $this->createForm(RatingType::class, $rate);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("LocalBundle:Annonce")->find($id);

        $koko = $em->getRepository('LocalBundle:Rating')->findOneBy(array('user' => $this->getUser(), 'annonce' => $annonce));
        if (!empty($koko)) {
            $okk = 1;
            $rate = $koko;
        }


        if ($form->isSubmitted()) {

            if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                throw $this->createAccessDeniedException();

            }
            $rate0 = $form->get('rating')->getData();
            $rate->setUser($this->getUser());
            $rate->setAnnonce($annonce);
            $rate->setRating($rate0);
            $em->persist($rate);
            $em->flush();
            $okk = 1;

        }
            return $this->render('LocalBundle:Default:single.html.twig', array(

                "annonce" => $annonce,
                'rate' => $rate,
                'form' => $form->createView(),
                'okk' => $okk
            ));



    }


}
