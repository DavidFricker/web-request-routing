<?php
namespace Overphish\Vendor\DavidFricker\Router\Controller;

use Overphish\Vendor\DavidFricker\DataAbstracter\Provider\AppContentProvider;
use DavidFricker\Router\Router;
use DavidFricker\Router\Capsule\Request;
use Philo\Blade\Blade;

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
class BaseRouteController {
    protected $AppContentProvider;
    protected $Blade;

    public function __construct() {
       $this->Blade = new Blade(BLADE_FOLDER_VIEWS, BLADE_FOLDER_CACHE);
       $this->AppContentProvider = AppContentProvider::init();
   }

    protected function render($template, $with=false) {
      if ($with) {
        die($this->Blade->view()->make($template)->with($with)->render());
      }

      die($this->Blade->view()->make($template)->render());
   }

   

/*
    public function reroute($route, $Request) {
      try {
        (new Router())->dispatch($route, $Request);
      } catch(\DavidFricker\Router\Exception\InvalidRouteException $e) {
        // Route not found i.e. 404
        return false;
      }
    }

*/





}