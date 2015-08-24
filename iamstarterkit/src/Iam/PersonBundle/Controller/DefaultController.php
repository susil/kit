<?php

namespace Iam\PersonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Iam\PersonBundle\Entity\Person;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        //$em = $this->container->get('doctrine')->getManager();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PersonBundle:Person');

        //$person = new Person();
        $person = $repo->findOneBy( array(
            'firstname'=>$name
        ));


        /*
         *
         return $this->render(
            'PersonBundle:Default:index.html.twig',
            array('name' => $name, 'person'=>$person));
        */

        $data = [
            'empid'=> $person->getEmployeeid(),
            'fn'=>$person->getFirstname(),
            'ln'=>$person->getLastname(),
            'status'=>$person->getStatus(),
            'title'=>$person->getTitle(),
            'id'=>$person->getId(),
            'enddate'=>$person->getEmpenddate(),

        ];


        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type','application/json');

        return $response;

    }
}
