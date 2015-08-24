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

use Iam\PersonBundle\Entity\Person;
$person= new Person();
$person->setEmployeeid(123123123);
$person->setFirstname('Scott');
$person->setLastname('tiger');
$person->setStatus('Active');
$person->setTitle('The Man');
$d1=new DateTime("2015-07-08 11:14:15.638276");
//$person->setEmpenddate($d1);


/*
 * //
 * //
 * //
echo 'Test1...';
echo $templating->render(
    'PersonBundle:Default:index.html.twig',
    array('name'=> 'Kevin Dale', 'no. of cars'=>5,'person'=>$person)
);

*/

/*

$em=$container->get('doctrine')->getManager();
$em->flush();
*/


use GuzzleHttp\Client;

//$client = new Client([
//    // Base URI is used with relative requests
//    'base_uri' => 'http://localhost:8080',
//    // You can set any number of default request options.
//    'timeout'  => 100.0,
//]);

//$client = new GuzzleHttp\Client(['base_uri' => 'http://localhost:80000/']);

/*
 *
 * Initial Call to authenticate yourself to the API server
 *
 */

echo 'Test- Calling External REST...\n\n';

try {


$client = new Client();
$response = $client->post('http://localhost:8080/iams/j_spring_security_check' ,
    [
        'debug' => true,
        'allow_redirects' => false,
//
//        'headers' => [
//            //'Accept'  => 'form_params',
//            //'Content-type'  => 'form_params',
//        ],
        'form_params' => [
            'j_username'=>'iams',
            'j_password'=>'1',
        ]
]);



// Get all of the response headers.
foreach ($response->getHeaders() as $name => $values) {
    echo $name . ': ' . implode(', ', $values) . "\r\n";
}


$x_auth_token = $response->getHeader("X-Auth-Token");

if ( isset($x_auth_token)) {
    echo "x_auth_token is ...=".$x_auth_token[0]."\n";

}
else {
    echo "X-Auth-token is not available, wrong credential...\n";
}


}
catch (Exception $e) {
    echo 'EXCEPTION........';
    echo $e->getMessage();
    echo 'TRACE........';
    echo "X-Auth-token is not available, wrong credential...\n";
    //echo $e->getTrace();

}


/*
 *
 * Now make call using the auth token for actual service : general person search
 *
 */
try {

if ( isset($x_auth_token)) {
    echo "x_auth_token is ...=".$x_auth_token[0];
    echo "use this token to make person search calls...\n";

    $response = $client->get('http://localhost:8080/iams/service/personsearch/susil' ,
        [
            'debug' => true,
            'allow_redirects' => false,

        'headers' => [
            'Accept'  => 'application/json',
            'X-Auth-Token'  => $x_auth_token,
          ]
        ]);

    echo 'Spitting response data';

    echo $response->getBody();

}

}
catch (Exception $e ) {
    echo "Exception while making WS call for data...\n";
    echo $e->getMessage();
}



/*
 *
 * Now make call using the auth token for actual service : general person detail
 *
 */
try {

    if ( isset($x_auth_token)) {
        echo "x_auth_token is ...=".$x_auth_token[0];
        echo "use this token to make person detail calls...\n";

        //$response = $client->get('http://localhost:8080/iams/service/persondetail/88834' ,
        $response = $client->get('http://localhost:8080/iams/service/persondetail/56133' ,
            [
                'debug' => true,
                'allow_redirects' => false,

                'headers' => [
                    'Accept'  => 'application/json',
                    'X-Auth-Token'  => $x_auth_token,
                ]
            ]);

        echo 'Spitting response data';

        echo $response->getBody();

    }

}
catch (Exception $e ) {
    echo "Exception while making WS call for data...\n";
    echo $e->getMessage();
}





