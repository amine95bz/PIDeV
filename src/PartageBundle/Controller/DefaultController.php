<?php

namespace PartageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PartageBundle:Default:index.html.twig');
    }
}
