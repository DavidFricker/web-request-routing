<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array('..','app','vendor','autoload.php'));
require_once __DIR__ . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array('..','app','overphish','const.php'));
require_once __DIR__ . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array('..','app','overphish','routes.php'));

use DavidFricker\Router\Router;
use DavidFricker\Router\Capsule\Request;

try {
	(new Router())->dispatch($_SERVER['PATH_INFO'], new Request());
} catch(\DavidFricker\Router\Exception\InvalidRouteException $e) {
	// Route not found i.e. 404
	echo 'page not found';
}
/*

# check for a static resource match
#if(isset()) {}

# check for a dynamic resource match
$url = '/path/92746/account';
$url_parts = explode('/',strtolower($url));

#foreach($routes as $resource) {
    $resource = '/path/{foo}/account';
    $resource_parts = explode('/',$resource);
    $varibles = [];
     var_dump($resource_parts,$url_parts);
    if(count($resource_parts) != count($url_parts)) {
        die('resource not a match');
    }

    for ($i=0; $i < count($resource_parts); $i++) {
        if ($resource_parts[$i] != $url_parts[$i]) {
            if(!stristr($resource_parts[$i],'{')) {
                // not a dynamic match
                continue;
            }
            
            $varibles[$resource_parts[$i]] = $url_parts[$i];
            

        }
    }
#}
*/
/*
#$matches = preg_match_all('/(\/path\/)(w+)(\/account)/', '/path/92746/account', $matches);
#$matches = preg_replace_callback('/(w+)/', function($i){ return '([\w-%]+)';}, '/path/(:id)/');
$str = '/path/92746/account';
$pattern = "/{[^}]* /";
$subject = "{token1} foo {token2} bar";
preg_match_all($pattern, $subject, $matches);
#print_r($matches);?><pre><?php print_r($varibles); ?></pre>*/
