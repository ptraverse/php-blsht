<?php

require_once __DIR__.'/vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
Request::enableHttpMethodParameterOverride();
date_default_timezone_set('America/Vancouver');

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

//static pages
$routes = array(
    'home' => array('url' => '/', 'template' => 'home.twig'),
    'date-differ' => array('url' => '/date-differ', 'template' => 'date-differ.twig')
);
foreach ($routes as $routeName => $data) {
    $app->get($data['url'], function() use($app, $data) {
        return $app['twig']->render($data['template']);
    })->bind($routeName);
}

//do the calculation on form POST
$app->post('dateDifferResult', function(Request $request) use ($app) {
	$start = array($request->get('y1'),$request->get('m1'),$request->get('d1'));	
	$end = array($request->get('y2'),$request->get('m2'),$request->get('d2'));	
	$dateDiffer = new DateDiffer($start, $end);
	$dateDiff = $dateDiffer->getDateDiff();	
	return new Response('<h1>' . $dateDiff . '</h1>');
});

$app->run();