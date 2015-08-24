<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
/*
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1')) || php_sapi_name() === 'cli-server')
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}
*/


$loader = require_once __DIR__.'/app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
//$response = $kernel->handle($request);
//$response->send();
//$kernel->terminate($request, $response);

$kernel->boot();

$container=$kernel->getContainer();
$container->enterScope('request');
$container->set('request',$request);


$templating = $container->get('templating');

echo $templating->render(
    'PersonBundle:Default:index.html.twig',
    array('name'=> 'Kevin Dale', 'no. of cars'=>5)
);

use Iam\PersonBundle\Entity\Person;

$person= new Person();
$person->setEmployeeid(123123123);
$person->setFirstname('Scott');
$person->setLastname('tiger');
$person->setStatus('Active');
$person->setTitle('The Man');
$d1=new DateTime("2015-07-08 11:14:15.638276");
//$person->setEmpenddate($d1);


$em=$container->get('doctrine')->getManager();
$em->persist($person);
$em->flush();





