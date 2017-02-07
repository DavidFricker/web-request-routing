<?php
namespace DavidFricker\Router\Capsule;

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
class Route {
    // url e.g. example.com/login -> login
    private $resource_route;
    
    // method@class or lambda func - method@namespace\class for namespaced classes
    private $target;
    
    // http method
    private $http_method;
    
    public function __construct($resource_route, $http_method, $target)
    {
        $this->resource_route = $resource_route;
        $this->http_method = $http_method;
        $this->target  = $target;
    }

    public function getTarget() {
      return $this->target;
    }

    public function getMethod() {
      return $this->method;
    }

    public function getResourceRoute() {
      return $this->resource_route;
    }
}