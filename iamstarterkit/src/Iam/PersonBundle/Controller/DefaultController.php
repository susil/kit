<?php

namespace Iam\PersonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        //$em = $this->container->get('doctrine')->getManager();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PersonBundle:Person');

        $person = $repo->findOneBy( array(
            'firstname'=>$name
        ));


        return $this->render(
            'PersonBundle:Default:index.html.twig',
            array('name' => $name, 'person'=>$person));



    }
}
