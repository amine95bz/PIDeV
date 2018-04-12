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

class CommandeController extends Controller
{
    public function facture(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $random = random_int(1, 20);

        $session = $request->getSession();
        $adresse = $session->get('adresse');
        $panier = $session->get('panier');
        $commande = array();
        $totalHT = 0;


        $facturation = $em->getRepository('CommandeBundle:UserAdress')->find($adresse['facturation']);
        $livraison = $em->getRepository('CommandeBundle:UserAdress')->find($adresse['livraison']);
        $produits = $em->getRepository('ProduitBundle:Produit')->findArray(array_keys($session->get('panier')));

        foreach($produits as $produit)
        {
            $prixHT = ($produit->getPrix() * $panier[$produit->getRef()]);

            $totalHT += $prixHT;



            $commande['produit'][$produit->getRef()] = array('reference' => $produit->getNomp(),
                'quantite' => $panier[$produit->getRef()],
                'prixHT' =>$produit->getPrix() );
        }

        $commande['livraison'] = array('prenom' => $livraison->getPrenom(),
            'nom' => $livraison->getNom(),
            'telephone' => $livraison->getTelephone(),
            'adresse' => $livraison->getAdresse(),
            'cp' => $livraison->getCp(),
            'ville' => $livraison->getVille(),
            'pays' => $livraison->getPays(),
            'complement' => $livraison->getComplement());

        $commande['facturation'] = array('prenom' => $facturation->getPrenom(),
            'nom' => $facturation->getNom(),
            'telephone' => $facturation->getTelephone(),
            'adresse' => $facturation->getAdresse(),
            'cp' => $facturation->getCp(),
            'ville' => $facturation->getVille(),
            'pays' => $facturation->getPays(),
            'complement' => $facturation->getComplement());

        $commande['prixHT'] = $totalHT;
        $commande['token'] =  $random;
        return $commande;
    }
    public function prepareCommandeAction(Request $request)
{
    $session = $request->getSession();
    $em = $this->getDoctrine()->getManager();
    $commande=new Commandes();



    $commande->setDate(new \DateTime());
    $commande->setUser($this->getUser());
    $commande->setValider(0);
    $commande->setReference(1);
    $commande->setCommande($this->facture($request));

        $em->persist($commande);


    $em->flush();

    return new Response($commande->getId());
}

    public function validationCommandeAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('CommandeBundle:Commandes')->find($id);

        if (!$commande || $commande->getValider() == 1)
            $this->get('session')->getFlashBag()->add('erreur','Commande n existe pas');

        $commande->setValider(1);
        $commande->setReference($this->container->get('setNewReference')->reference());
        $em->flush();

        $session = $request->getSession();
        $session->remove('adresse');
        $session->remove('panier');
         $session->remove('commande');


        //Ici le mail de validation
        $message = \Swift_Message::newInstance()
            ->setSubject('Validation de votre commande')
            ->setFrom(array('fares.maghzaoui@esprit.tn' => "Souk El Medina"))
            ->setTo($commande->getUser()->getEmailCanonical())
            ->setCharset('utf-8')
            ->setContentType('text/html')
            ->setBody($this->renderView('CommandeBundle:commande:validationCommande.html.twig',array('user' => $commande->getUser())));

        $this->get('mailer')->send($message);

        $this->get('session')->getFlashBag()->add('success','Votre commande est validé avec succès');
        return $this->redirect($this->generateUrl('factures'));
    }









    }