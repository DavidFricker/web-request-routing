<?php
namespace DavidFricker\Router;

use DavidFricker\Router\RouteContainer;

/**
  * A wrapper around a DB driver to expose a uniform interface
  *
  * Bassically an abstraction over the complexity of the PDO class, but by design this could wrap any strctured storage mechanism 
  * A database engine adapter
  *
  * @param string $myArgument With a *description* of this argument, these may also
  *    span multiple lines.
  *
  * @return void
  */
class Router {
    private $RouteContainer;

    public function __construct() {
       $this->RouteContainer = RouteContainer::init();
    }

    public function dispatch($resource_route, $request) {
      $route = $this->RouteContainer->get($resource_route, $request->get_method());

      // check if the supplied callback is a lambda function or a string identifying a controller
      if (!is_string($route->getTarget())) {
        // could have used the following line but call_user_func is clearer$var = $route->getTarget();$var($request);
        call_user_func($route->getTarget(), $request);
        return;
      }

      // route the request to the correct controller
      $target = explode('@', $route->getTarget());
      if (count($target) != 2) {
        //throw error
      }
      
      $method_name = $target[0];
      $controller_name = $target[1];

      // check controller exists, else command is invalid
      if (!class_exists($controller_name)) {
          die('class not found');
      }

      // initalise the controller class
      $controller = new $controller_name();

      // ensure the method corresponding to the action exists, allowing a graceful fail otherwise 
      if (!method_exists($controller, $method_name)) {
         die('METHOD not found');
      }

      // call method on controller object
      call_user_func(array($controller, $method_name), $request);
    }
}