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

$lines = file('users.txt');
$users = array()
foreach($response_lines as $line) {
    $bits = explode(':', $line);
    $user_name = array_shift($bits);
    $user_pass = implode('=', $bits);
    $users[$user_name] = $user_pass;
}

$app->get('/static', function() use($app) {
  $app['monolog']->addDebug('static page');
  return $app['twig']->render('static.twig');
});

$app->get('/dynamic', function() use($app) {
	$app['monolog']->addDebug('dynamic page');
	$user = $_REQUEST['user']
	$pass = $_REQUEST['pass']
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
