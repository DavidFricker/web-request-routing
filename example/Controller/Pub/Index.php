<?php

namespace Overphish\Vendor\DavidFricker\Router\Controller\Pub;

use Overphish\Vendor\DavidFricker\Router\Controller\PublicRouteController;

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
class Index extends PublicRouteController {
    public function getPageIndex($Request) {
      $this->render('index', ['page' => 'index']);
    }
}
