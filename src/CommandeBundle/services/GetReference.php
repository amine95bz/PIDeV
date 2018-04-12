<?php
namespace CommandeBundle\services;

use Symfony\Component\Security\Core\SecurityContextInterface;

class GetReference 
{
    public function __construct($securitytoken_storage, $entityManager)
    {
        $this->securitytoken_storage = $securitytoken_storage;
        $this->em = $entityManager;
    }
    
    public function reference()
    {
        $reference = $this->em->getRepository('CommandeBundle:Commandes')->findOneBy(array('valider' => 1), array('id' => 'DESC'),1,1);
        
        if (!$reference)
            return 1;
        else 
            return $reference->getReference() +1;
    }
}