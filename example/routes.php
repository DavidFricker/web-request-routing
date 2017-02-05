<?php
require __DIR__ . '\..\src\Route.php';
require __DIR__ . '\..\src\RouteContainer.php';
require __DIR__ . '\..\src\AuthRouteController.php';
use DavidFricker\Router\RouteContainer;

$RouteContainer = RouteContainer::init();

//$RouteContainer->set('/login',HTTP_METHOD_GET, 'getLogin@AuthPagesController');
$RouteContainer->set('/login', RouteContainer::HTTP_METHOD_GET, function($request) {
	echo 'this is the login page';
	
	var_dump($request);
});

$RouteContainer->set('/logout', RouteContainer::HTTP_METHOD_GET, 'getLogoutPage@DavidFricker\Router\AuthRouteController');