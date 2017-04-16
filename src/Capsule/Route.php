<?php

namespace DavidFricker\Router\Capsule;

/**
  * Representation of a request route e.g. /dashboard or /home
  */
class Route {
    /**
     * If the request were to 'example.com/login', this member should contain 'login'
     * @var string
     */
    private $resource_route;
    
    /**
     * String: representation of method, namespace, and class e.g. 'method@namespace\class'
     * Function: an anonymous function that accepts a Request object as a parameter
     * @var mixed
     */
    private $target;
    
    /**
     * HTTP method
     * @var string
     */
    private $http_method;
    
    public function __construct($resource_route, $http_method, $target)
    {
        $this->resource_route = $resource_route;
        $this->http_method = $http_method;
        $this->target  = $target;
    }

    /**
     * Fetch the target of the route
     * 
     * @return mixed The target can be a string identifying a method and class or it can be an anonymous function
     */
    public function getTarget() {
      return $this->target;
    }

    /**
     * Fetch the method the route is declared to handle
     * 
     * @return string standard HTTP verbiage
     */
    public function getMethod() {
      return $this->method;
    }

    /**
     * Fetch the route
     * 
     * @return string route, as requested by client e.g. /dashboard/load
     */
    public function getResourceRoute() {
      return $this->resource_route;
    }
}
