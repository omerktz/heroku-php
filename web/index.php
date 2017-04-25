<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('index page');
  return $app['twig']->render('index.html');
});

$app['monolog']->addDebug('loading users');
$lines = file('users.txt');
foreach($lines as $line) {
    $bits = explode(':', $line);
    $user_name = array_shift($bits);
    $user_pass = implode('=', $bits);
    $users[$user_name] = $user_pass;
}
$app['monolog']->addDebug('loaded '.count($users).' users');

$app->get('/static', function() use($app) {
  $app['monolog']->addDebug('static page');
  return $app['twig']->render('static.html');
});

$app->get('/dynamic', function() use($app) {
	$app['monolog']->addDebug('dynamic page');
	$user = $_GET['user'];
	$pass = $_GET['pass'];
	if(array_key_exists($user,$users)) {
		if($users[$user] == $pass) {
			return $app['twig']->render('dynamic_ok.twig');
		} else {
			return $app['twig']->render('dynamic_fail.twig');
		}
	} else {
  		return $app['twig']->render('dynamic_fail.twig');
	}
});

$app->run();
