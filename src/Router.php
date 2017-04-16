<?php

namespace DavidFricker\Router;

use DavidFricker\Router\Capsule\RouteContainer;
use DavidFricker\Router\Exception\InvalidRouteException;
use DavidFricker\Router\Exception\InvalidControllerException;

/**
 * Automatic request routing class
 */
class Router {
    /**
     * Contains the instance of the RouteContainer class (singleton)
     * @var RouteContainer
     */
    private $RouteContainer;

    public function __construct() {
       $this->RouteContainer = RouteContainer::init();
    }

    /**
     * Serves a HTTP request.
     *
     * @throws InvalidRouteException
     * @throws InvalidControllerException
     * 
     * @param  string $resource_route The query URI
     * @param  Request $Request        Instance of the Request object
     * @return void
     */
    public function dispatch($resource_route, $Request) {
      $route = $this->RouteContainer->get($resource_route, $Request->getMethod());
      if (!$route) {
        throw new InvalidRouteException('Route not recognised');
      }
      
      // check if the supplied callback is a annonymous function or a string identifying a controller
      if (is_callable($route->getTarget())) {
        // could have used the following line but call_user_func is clearer than $var = $route->getTarget();$var($Request);
        call_user_func($route->getTarget(), $Request);
        return;
      }

      // route the request to the correct controller
      $target = explode('@', $route->getTarget());
      if (count($target) != 2) {
        throw new InvalidControllerException('The target of the Route object must be a lambda function or a string defined as method@namespace\\class');
      }
      
      $method_name = $target[0];
      $controller_name = $target[1];

      // check controller exists, else command is invalid
      if (!class_exists($controller_name)) {
          throw new InvalidControllerException('Controller not found');
      }

      // initalise the controller class
      $controller = new $controller_name();

      // ensure the method corresponding to the action exists, allowing a graceful fail otherwise 
      if (!method_exists($controller, $method_name)) {
        // SPL Exception
        throw new \BadFunctionCallException('Controller method not found');
      }

      $Request->setParsedUrlParameters($this->RouteContainer->getParsedUrlParameters());

      // call method on controller object
      call_user_func(array($controller, $method_name), $Request);
    }
}
