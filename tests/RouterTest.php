<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use DavidFricker\Router\Router;
use DavidFricker\Router\Capsule\RouteContainer;
use DavidFricker\Router\Capsule\Request;
use DavidFricker\Router\Exception\InvalidRouteException;
use DavidFricker\Router\Exception\InvalidControllerException;
/**
 * @covers Router
 */
final class RouterTest extends TestCase
{    
    private static $Router;

    public static function setUpBeforeClass()
    {
        self::$Router = new Router();
    }

    /**
     * @expectedException DavidFricker\Router\Exception\InvalidRouteException
     */
    public function testDispatchNoRoute()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $Request = new Request();

        self::$Router->dispatch('', $Request);
    }

    /**
     * @expectedException DavidFricker\Router\Exception\InvalidControllerException
     */
    public function testDispatchInvalidControllerString()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $Request = new Request();

        $RouteContainer = RouteContainer::init();
        $RouteContainer->set('/home', RouteContainer::HTTP_METHOD_GET, 'this_is_invalid');

        self::$Router->dispatch('home', $Request);
    }

    /**
     * @expectedException DavidFricker\Router\Exception\InvalidControllerException
     */
    public function testDispatchValidControllerStringMissingControllerClass()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $Request = new Request();

        $RouteContainer = RouteContainer::init();
        $RouteContainer->set('/home', RouteContainer::HTTP_METHOD_GET, 'getPage@DavidFricker\Router\Example\Controller\Does\Not\Exist');

        self::$Router->dispatch('home', $Request);
    }

    /**
     * @expectedException DavidFricker\Router\Exception\InvalidControllerException
     */
    public function testDispatchValidControllerStringPresentControllerClassMissingMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $Request = new Request();

        $RouteContainer = RouteContainer::init();
        $RouteContainer->set('/home', RouteContainer::HTTP_METHOD_GET, 'missingMethodHere@DavidFricker\Router\Example\Controller\Pub\Index');

        self::$Router->dispatch('home', $Request);
    }

    public function testDispatchCorrect() 
    {
        $this->expectOutputString('controller output - foo');

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $Request = new Request();

        $RouteContainer = RouteContainer::init();
        $RouteContainer->set('/home', RouteContainer::HTTP_METHOD_GET, function(){echo 'controller output - foo';});

        self::$Router->dispatch('home', $Request);
    }
}
