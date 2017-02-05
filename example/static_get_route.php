<?php
require __DIR__ . '\..\src\Router.php';
require __DIR__ . '\..\src\Request.php';
require 'routes.php';

use DavidFricker\Router\Router;
use DavidFricker\Router\Request;

(new Router())->dispatch('/login', new Request());