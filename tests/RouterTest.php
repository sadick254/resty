<?php

use PHPUnit\Framework\TestCase;
use Resty\Router;

class RouterTest extends TestCase
{
    public function testCanExecuteGetRequestCallback()
    {
        $config = ['REQUEST_URI' => '/users', 'REQUEST_METHOD' => 'GET'];
        $api = new Router();
        $this->called = false;
        $callback = function ($req, $res) {
            $this->called = true;
        };
        $api->get('/users', $callback);
        $api->serve($config);
        $this->assertTrue($this->called);
    }

    public function testCanExecutePostRequestCallback()
    {
        $config = ['REQUEST_URI' => '/users', 'REQUEST_METHOD' => 'POST'];
        $api = new Router();
        $this->called = false;
        $callback = function ($req, $res) {
            $this->called = true;
        };
        $api->post('/users', $callback);
        $api->serve($config);
        $this->assertTrue($this->called);
    }

    public function testCanExecutePutRequestCallback()
    {
        $config = ['REQUEST_URI' => '/users', 'REQUEST_METHOD' => 'PUT'];
        $api = new Router();
        $this->called = false;
        $callback = function ($req, $res) {
            $this->called = true;
        };
        $api->put('/users', $callback);
        $api->serve($config);
        $this->assertTrue($this->called);
    }

    public function testCanExecuteDeleteRequestCallback()
    {
        $config = ['REQUEST_URI' => '/users', 'REQUEST_METHOD' => 'DELETE'];
        $api = new Router();
        $this->called = false;
        $callback = function ($req, $res) {
            $this->called = true;
        };
        $api->delete('/users', $callback);
        $api->serve($config);
        $this->assertTrue($this->called);
    }

    public function testCanParseParams()
    {
        $config = ['REQUEST_URI' => '/users/1', 'REQUEST_METHOD' => 'GET'];
        $api = new Router();
        $this->params = (object) [];
        $callback = function ($req, $res) {
            $this->params = $req->getParams();
        };
        $api->get('/users/:id', $callback);
        $api->serve($config);

        $this->assertEquals($this->params->id, 1);
    }
    public function testCanParseQueryParams()
    {
        $config = [
            'REQUEST_URI' => '/users?name=isaac',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'name=isaac',
        ];
        $api = new Router();
        $this->params = (object) [];
        $callback = function ($req, $res) {
            $this->params = $req->getQueryParams();
        };
        $api->get('/users', $callback);
        $api->serve($config);

        $this->assertEquals($this->params->name, 'isaac');
    }

    public function testCanExecuteMiddleware()
    {
        $config = ['REQUEST_URI' => '/users/1', 'REQUEST_METHOD' => 'GET'];
        $api = new Router();
        $this->called = false;
        $logger = function ($req, $res, $next) {
            $this->called = true;
        };
        $api->use($logger);
        $api->serve($config);
        $this->assertTrue($this->called);
    }
    public function testCanExecuteMiddlewareOnRoute()
    {
        $config = ['REQUEST_URI' => '/users/1', 'REQUEST_METHOD' => 'GET'];
        $api = new Router();
        $this->called = false;
        $logger = function ($req, $res, $next) {
            $this->called = true;
        };
        $api->use("/users/:id", $logger);
        $api->serve($config);
        $this->assertTrue($this->called);
    }

    public function testCanAcceptMultipleMiddlewaresOnRoute()
    {
        $config = ['REQUEST_URI' => '/users', 'REQUEST_METHOD' => 'GET'];
        $this->loggerCalled = false;
        $logger = function ($req, $res, $next) {
            $this->loggerCalled = true;
            $next();
        };
        $this->timerCalled = false;
        $timer = function ($req, $res, $next) {
            $this->timerCalled = true;
            $next();
        };
        $this->called = false;
        $callback = function ($req, $res) {
            $this->called = true;
        };
        $api = new Router();
        $api->get('/users', $logger, $timer, $callback);
        $api->serve($config);
        $this->assertTrue($this->loggerCalled);
        $this->assertTrue($this->timerCalled);
        $this->assertTrue($this->called);

    }

    public function testCanAcceptMultipleMiddlewaresBeforeAndAfterOnRoute()
    {
        $config = ['REQUEST_URI' => '/users', 'REQUEST_METHOD' => 'GET'];
        $this->loggerCalled = false;
        $logger = function ($req, $res, $next) {
            $this->loggerCalled = true;
            $next();
        };
        $this->called = false;
        $callback = function ($req, $res) {
            $this->called = true;
        };
        $api = new Router();
        $api->get('/users', $logger, $callback);
        $api->serve($config);
        $this->assertTrue($this->loggerCalled);
        $this->assertTrue($this->called);

    }
}
