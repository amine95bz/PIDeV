<?php
namespace CommandeBundle\Controller;


use CommandeBundle\Entity\UserAdress;
use CommandeBundle\Form\UserAdressType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use CommandeBundle\Repository;
use Symfony\Component\HttpFoundation\RedirectResponse;
class PanierController extends Controller
{

    public function menuAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));

        return $this->render('CommandeBundle:panier:index.html.twig', array('articles' => $articles));
    }
    public function supprimerAction(Request $request,$ref)
    {{
        $session = $request->getSession();
        $panier = $session->get('panier');

        if (array_key_exists($ref, $panier))
        {
            unset($panier[$ref]);
            $session->set('panier',$panier);
            $this->get('session')->getFlashBag()->add('success','Article supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('panier'));
    }
    }

    public function ajouterAction(Request $request,$ref)
    {

        $session = $request->getSession();

        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');

        if (array_key_exists($ref, $panier)) {
            if ($request->query->get('quantit') != null) $panier[$ref] = $request->query->get('quantit');
            $this->get('session')->getFlashBag()->add('success','Quantité modifié avec succès');
        } else {
            if ($request->query->get('quantit') != null)
                $panier[$ref] = $request->query->get('	quantit');
            else
                $panier[$ref] = 1;

            $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');
        }

        $session->set('panier',$panier);


        return $this->redirect($this->generateUrl('panier'));
    }

    public function panierAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')) $session->set('panier', array());

        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ProduitBundle:Produit')->findArray(array_keys($session->get('panier')));

        return $this->render('CommandeBundle:panier:index.html.twig', array('produits' => $produits,
            'panier' => $session->get('panier')));
    }
    public function adresseSuppressionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CommandeBundle:UserAdress')->find($id);

        if ($this->getUser() != $entity->getUser() || !$entity)
            return $this->redirect ($this->generateUrl ('livraison'));

        $em->remove($entity);
        $em->flush();

        return $this->redirect ($this->generateUrl ('livraison'));
    }
    public function setLivraisonOnSession(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('adress')) $session->set('adress',array());
        $adresse = $session->get('adress');

        if ($request->get('livraison') != null && $request->get('facturation') != null)
        {
            $adresse['livraison'] =$request->get('livraison');
            $adresse['facturation'] = $request->get('facturation');
        } else {
            return $this->redirect($this->generateUrl('validation'));
        }

        $session->set('adresse',$adresse);
        return $this->redirect($this->generateUrl('validation'));
    }
    public function livraisonAction(Request $request){

        $user = $this->getUser();
        $entity = new UserAdress();
        $form = $this->createForm(UserAdressType::class,$entity);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity->setUser($user);
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('livraison'));
            }
        }

        return $this->render('CommandeBundle:panier:livraison.html.twig', array('user' => $user,
            'form' => $form->createView()));

    }
    public function validationAction(Request $request)
    {

        if ($request->isMethod('POST'))
            $this->setLivraisonOnSession($request);

        $em = $this->getDoctrine()->getManager();
        $prepareCommande = $this->forward('CommandeBundle:Commande:prepareCommande');
        $commande = $em->getRepository('CommandeBundle:Commandes')->find($prepareCommande->getContent());

        return $this->render('CommandeBundle:panier:validation.html.twig', array('commande' => $commande));

    }
}
