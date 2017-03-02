<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use DavidFricker\Router\Capsule\RouteContainer;
use DavidFricker\Router\Capsule\Route;
use DavidFricker\Router\Exception\InvalidHTTPMethodException;

/**
 * @covers RouteContainer
 */
final class RouteContainerTest extends TestCase
{
    public function testSetRouteStringCallback() {
        $RouteContainer = RouteContainer::init();

        $RouteContainer->set('/home', RouteContainer::HTTP_METHOD_GET, 'getPage@DavidFricker\Router\Example\Controller\Pub\Index');

        $route = $RouteContainer->get('/home', RouteContainer::HTTP_METHOD_GET);
        
        $this->assertEquals(
            Route::class,
            get_class($route)
        );
            
        $this->assertEquals(
            'getPage@DavidFricker\Router\Example\Controller\Pub\Index',
            $route->getTarget()
        );
    }

    public function testSetRouteFuncCallback() {
        $RouteContainer = RouteContainer::init();

        $RouteContainer->set('/home', RouteContainer::HTTP_METHOD_GET, function(){

        });

        $route = $RouteContainer->get('/home', RouteContainer::HTTP_METHOD_GET);
        
        $this->assertEquals(
            Route::class,
            get_class($route)
        );
            
        $this->assertEquals(
            function(){},
            $route->getTarget()
        );
    }

 
    public function testGetRouteStringCallbackInvalidHttpMethod() {
        $RouteContainer = RouteContainer::init();

        $RouteContainer->set('/home', RouteContainer::HTTP_METHOD_GET, function(){

        });

        $route = $RouteContainer->get('/home', RouteContainer::HTTP_METHOD_POST);
        
        $this->assertEquals(
            false,
            $route
        );
    }

    /**
     * @expectedException DavidFricker\Router\Exception\InvalidHTTPMethodException
     */
    public function testsetRouteFuncCallbackInvalidHttpMethod() {
        $RouteContainer = RouteContainer::init();

        $RouteContainer->set('/home', 6548, function(){ });
    }

    /**
     * @expectedException DavidFricker\Router\Exception\InvalidHTTPMethodException
     */
    public function testGetRouteFuncCallbackInvalidHttpMethod() {
        $RouteContainer = RouteContainer::init();

        $RouteContainer->set('/home', RouteContainer::HTTP_METHOD_POST, function(){ });

        $route = $RouteContainer->get('/home', 6548);
    }

    public function testGetParsedParametersOneParam() {
        $RouteContainer = RouteContainer::init();

        $RouteContainer->set('/home/{token}', RouteContainer::HTTP_METHOD_POST, function(){ });

        $route = $RouteContainer->get('/home/12345qwert', RouteContainer::HTTP_METHOD_POST);

        $this->assertArrayHasKey('token', $RouteContainer->getParsedUrlParameters());

        $this->assertEquals(
            '12345qwert',
            $RouteContainer->getParsedUrlParameters()['token']
        );
    }

    public function testGetParsedParametersTwoParams() {
        $RouteContainer = RouteContainer::init();

        $RouteContainer->set('/home/{token}/{second}', RouteContainer::HTTP_METHOD_POST, function(){ });

        $route = $RouteContainer->get('/home/12345qwert/ayye', RouteContainer::HTTP_METHOD_POST);

        $this->assertArrayHasKey('token', $RouteContainer->getParsedUrlParameters());
        $this->assertArrayHasKey('second', $RouteContainer->getParsedUrlParameters());

        $this->assertEquals(
            '12345qwert',
            $RouteContainer->getParsedUrlParameters()['token']
        );

        $this->assertEquals(
            'ayye',
            $RouteContainer->getParsedUrlParameters()['second']
        ); 
    }
    
}
