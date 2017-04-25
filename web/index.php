<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = false;

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

$app->get('/dynamic', function() use($app,$users) {
	$app['monolog']->addDebug('dynamic page');
	$user = $_GET['user'];
	$pass = $_GET['pass'];
	$app['monolog']->addDebug('user is '.$user.', pass is '.$pass);
	if(array_key_exists($user,$users)) {
		if(strcmp($users[$user],$pass)) {
			return $app['twig']->render('dynamic_pass.html');
		} else {
			return $app['twig']->render('dynamic_fail.html');
		}
	} else {
  		return $app['twig']->render('dynamic_fail.html');
	}
});

$app->run();
