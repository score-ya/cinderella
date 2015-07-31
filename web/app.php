<?php

use ScoreYa\Cinderella\App\AppKernel;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__ . '/../var/bootstrap.php.cache';
$kernel = new AppKernel($_SERVER['SYMFONY_ENV'], (bool)$_SERVER['SYMFONY_DEBUG']);
$kernel->loadClassCache();

$request  = Request::createFromGlobals();
$response = $kernel->handle($request);

$response->send();
$kernel->terminate($request, $response);