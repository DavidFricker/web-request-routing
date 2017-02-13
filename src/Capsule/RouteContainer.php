<?php
namespace DavidFricker\Router\Capsule;

use DavidFricker\Router\Capsule\Route;
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
  *
 * Singleton class
 *
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
    
    public static function init() {
        static $instance = null;

        if ($instance === null) {
            $instance = new RouteContainer();
        }

        return $instance;
    }

    public function set($resource_route, $http_method, $callback) {
      $this->getContainerForMethod($http_method)[trim($resource_route,'/')] = new Route(trim($resource_route,'/'), $http_method, $callback);
    }

    public function get($resource_route, $http_method) {
      // deal with trailing slashes
      $resource_route = trim($resource_route,'/');

      # check for a static resource match
      if (isset($this->getContainerForMethod($http_method)[$resource_route])) {
        return $this->getContainerForMethod($http_method)[$resource_route];
      }

      # check for a dynamic resource match
      $url_parts = explode('/', strtolower($resource_route));

      foreach($this->getContainerForMethod($http_method) as $route_as_index => $route_object) {
          $resource_parts = explode('/', $route_as_index);
          
          if (count($resource_parts) != count($url_parts)) {
              continue;
          }

          for ($i=0; $i < count($resource_parts); $i++) {
              if ($resource_parts[$i] == '' || $resource_parts[$i] != $url_parts[$i]) {
                  // treating the string as an array skips a method call to stristr, woo!
                  if($resource_parts[$i][0] != '{') {
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

    public function getParsedUrlParameters () {
      return $this->parsed_url_parameters;
    }

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
     * Set a private __construct to stop instaces being created leading to more than one instance of this class
     */
    private function __construct() {}
}