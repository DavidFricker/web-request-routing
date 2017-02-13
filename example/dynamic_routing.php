<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array('..','app','vendor','autoload.php'));
require_once __DIR__ . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array('..','app','overphish','const.php'));
require_once __DIR__ . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array('..','app','overphish','routes.php'));

use DavidFricker\Router\Router;
use DavidFricker\Router\Capsule\Request;

if(isset($_SERVER['PATH_INFO'])) {
    $path = $_SERVER['PATH_INFO'];
}else{
    $path ='/';
}

try {
    (new Router())->dispatch($path, new Request());
} catch(\DavidFricker\Router\Exception\InvalidRouteException $e) {
    // Route not found i.e. 404
    echo 'page not found';
}