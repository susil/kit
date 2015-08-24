<?php

namespace Iam\PersonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PersonBundle:Default:index.html.twig', array('name' => $name));



    }
}
