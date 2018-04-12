<?php
namespace CommandeBundle\services;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Spipu\Html2Pdf\Html2Pdf;

class GetFacture 
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function facture($facture)
    {
        $html = $this->container->get('templating')->render('BaseBundle:fares:facturePDF.html.twig', array('facture' => $facture));
        
        $html2pdf = new Html2Pdf();
        $html2pdf->pdf->SetAuthor('DevAndClick');
        $html2pdf->pdf->SetTitle('Facture '.$facture->getReference());
        $html2pdf->pdf->SetSubject('Facture DevAndClick');
        $html2pdf->pdf->SetKeywords('facture,devandclick');
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        
        return $html2pdf;
    }
}