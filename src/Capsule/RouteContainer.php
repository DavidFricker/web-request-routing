<?php

namespace DavidFricker\Router\Capsule;

use DavidFricker\Router\Capsule\Route;
use DavidFricker\Router\Exception\InvalidHTTPMethodException;

/**
 * Container class for Route objects.
 *
 * Provides an intelligent getter method that matches URL paths to template paths and also parses the requested information according to the template path.
 */
final class RouteContainer
{
    private $routes_get = [];
    private $routes_post = [];
    private $routes_delete = [];
    private $routes_put = [];
    private $parsed_url_parameters = [];

    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';
    const HTTP_METHOD_DELETE = 'DELETE';
    const HTTP_METHOD_PUT = 'PUT';
    
    /**
     * Returns the instance of the container
     *
     * This is a singleton class.
     * 
     * @return RouteContainer RouteContainer object
     */
    public static function init() {
        static $instance = null;

        if ($instance === null) {
            $instance = new RouteContainer();
        }

        return $instance;
    }

    /**
     * Save a template route to the container
     *
     * Store a template route along with the HTTP request method it servers and the call-back method to handle the request
     * 
     * @param string $resource_route tempalte route/path
     * @param string $http_method    one of the HTTP_METHOD_* constants found in this class
     * @param string|function $callback       [description]
     */
    public function set($resource_route, $http_method, $callback) {
      $this->getContainerForMethod($http_method)[trim($resource_route,'/')] = new Route(trim($resource_route,'/'), $http_method, $callback);
    }

    /**
     * Retrieve the Route object for a given path and HTTP request method
     *
     * Will match the actual route/path from the HTTP request to a template or exact match route stored in the container.
     * This method will parse and store the the real request path according to the template request path.
     *
     * @example if the template route path were 'path/to/article/{article_id}', the actual route path were 'path/to/article/4455', then the array [article_id => 4455] would be passed to this method
     * 
     * @param  string $resource_route requested route/path from client connection
     * @param  string $http_method    one of the HTTP_METHOD_* constants found in this class
     * @return Route                  Route object
     */
    public function get($resource_route, $http_method) {
      // deal with trailing slashes
      $resource_route = trim($resource_route,'/');

      # check for a static resource match
      if (isset($this->getContainerForMethod($http_method)[$resource_route])) {
        return $this->getContainerForMethod($http_method)[$resource_route];
      }

      # check for a dynamic resource match
      $url_parts = explode('/', $resource_route);

      foreach($this->getContainerForMethod($http_method) as $route_as_index => $route_object) {
          $resource_parts = explode('/', $route_as_index);
          
          if (count($resource_parts) != count($url_parts)) {
              continue;
          }

          for ($i = 0; $i < count($resource_parts); $i++) {
              if ($resource_parts[$i] != $url_parts[$i]) {
                  // treating the string as an array skips a method call to stristr, woo!
                  if($resource_parts[$i] == '' || $resource_parts[$i][0] != '{') {
                      // not a dynamic match
                      $this->parsed_url_parameters = [];
                      continue 2;
                  }

                  
                  $this->parsed_url_parameters[trim($resource_parts[$i],'{}')] = $url_parts[$i];
              }
          }

          return $route_object;
      }

      return false;
    }

    /**
     * Fetch the parsed path elements
     *
     * Parsing of URL elements happens in the get() method
     * 
     * @return array an associative array of parsed URL parameters
     */
    public function getParsedUrlParameters() {
      return $this->parsed_url_parameters;
    }

    /**
     * Fetches the correct internal container array for a given HTTP request method
     * 
     * @param  string $http_method one of the HTTP_METHOD_* constants found in this class
     * @return array               reference to correct internal route storage array
     */
    private function &getContainerForMethod($http_method) {
       switch($http_method) {
          case self::HTTP_METHOD_GET:
            return $this->routes_get;
            break;

          case self::HTTP_METHOD_POST:
            return $this->routes_post;
            break;

          case self::HTTP_METHOD_DELETE:
            return $this->routes_delete;
            break;

          case self::HTTP_METHOD_PUT:
            return $this->routes_put;
            break;

          default:
            throw new InvalidHTTPMethodException('This HTTP method is not supported');
            break;
      }
    }

    /**
     * private __construct to stop instaces being created leading to more than one instance of this class
     */
    private function __construct() {}
}