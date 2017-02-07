<?php
require __DIR__ . '\..\src\Capsule\Route.php';
require __DIR__ . '\..\src\Capsule\RouteContainer.php';
require __DIR__ . '\..\src\Controller\BaseRouteController.php';
require __DIR__ . '\..\src\Controller\AuthRouteController.php';

use DavidFricker\Router\Capsule\RouteContainer;

$RouteContainer = RouteContainer::init();

$RouteContainer->set('/logout', RouteContainer::HTTP_METHOD_GET, 'getLogoutPage@DavidFricker\Router\Controller\AuthRouteController');

$RouteContainer->set('/login', RouteContainer::HTTP_METHOD_GET, function($request) {
	echo 'this is the login page';
	
	var_dump($request);
});