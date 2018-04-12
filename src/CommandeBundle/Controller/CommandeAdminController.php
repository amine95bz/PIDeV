<?php
/**
 * Created by PhpStorm.
 * User: fares
 * Date: 08/04/2018
 * Time: 05:31
 */

namespace CommandeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use CommandeBundle\Entity\UserAdress;
use CommandeBundle\Entity\Commandes;
use ProduitBundle\Entity\Produit;

class CommandeAdminController extends Controller
{



    public function commandesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('CommandeBundle:Commandes')->findAll();

        return $this->render('CommandeBundle:Commande:index.html.twig', array('commandes' => $commandes));
    }

    public function showFactureAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('CommandeBundle:Commandes')->find($id);

        if (!$facture) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('adminCommande'));
        }

        $this->container->get('setNewFacture')->facture($facture)->Output('Facture.pdf');

        $response = new Response();
        $response->headers->set('Content-type' , 'application/pdf');

        return $response;
    }





}