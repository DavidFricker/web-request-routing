<?php
namespace DavidFricker\Router;

use DavidFricker\Router\Route;
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
      $this->getContainerForMethod($http_method)[$resource_route] = new Route($resource_route, $http_method, $callback);
    }

    public function get($resource_route, $http_method) {
      if (!isset($this->getContainerForMethod($http_method)[$resource_route])) {
        return false;
      }

      return $this->getContainerForMethod($http_method)[$resource_route];
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