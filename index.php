<?php

require_once __DIR__.'/vendor/autoload.php';

date_default_timezone_set('America/Vancouver');

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$routes = array(
    'home' => array('url' => '/', 'template' => 'home.twig'),
    'date-differ' => array('url' => '/date-differ', 'template' => 'date-differ.twig')
);

foreach ($routes as $routeName => $data) {
    $app->get($data['url'], function() use($app, $data) {
        return $app['twig']->render($data['template']);
    })->bind($routeName);
}

$app->get('/hello/{name}', function($name) use($app) {
    return 'Hello '.$app->escape($name);
});

$app->run();