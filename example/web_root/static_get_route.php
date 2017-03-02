<?php
require __DIR__ . '\..\..\src\Router.php';
require __DIR__ . '\..\..\src\Capsule\Request.php';
require '../routes.php';

use DavidFricker\Router\Router;
use DavidFricker\Router\Capsule\Request;

(new Router())->dispatch('/logout', new Request());