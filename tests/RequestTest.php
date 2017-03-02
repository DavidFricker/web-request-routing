<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use DavidFricker\Router\Capsule\Request;
use DavidFricker\Router\Capsule\Route;
use DavidFricker\Router\Exception\InvalidHTTPMethodException;

/**
 * @covers Request
 */
final class RequestTest extends TestCase
{
    public function testGetRequestMethod() {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $Request = new Request();

        $this->assertEquals(
            'POST',
            $Request->getMethod()
        );
    }

    public function testPathInfoSplitOnePart() {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PATH_INFO'] = '/foo';
        $Request = new Request();

        $this->assertEquals(
            'foo',
            $Request->getUrlElements(0)
        );
    }

    public function testPathInfoSplitTwoParts() {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PATH_INFO'] = '/foo/bar';
        $Request = new Request();

        $this->assertEquals(
            'foo',
            $Request->getUrlElements(0)
        );

        $this->assertEquals(
            'bar',
            $Request->getUrlElements(1)
        );
    }

    public function testGetGetParamPresent() {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['foo'] = 'bar';

        $Request = new Request();

        $this->assertEquals(
            'bar',
            $Request->getParameters('foo')
        );
    }

    public function testGetGetParamNotPresent() {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['foo'] = 'bar';

        $Request = new Request();

        $this->assertEquals(
            false,
            $Request->getParameters('notanindex')
        );
    }
}
