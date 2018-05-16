<?php
namespace Resty;

class Router
{
    private $routes = [];
    private $request;
    private $middlewares = [];
    private $response;

    function use () {
        $args = \func_get_args();
        $path = 'ALL';
        $callback = null;
        foreach ($args as $arg) {
            if (is_callable($arg)) {
                $callback = $arg;
            } else {
                $path = $arg;
            }
        }
        $this->routes[] = new Middleware($path, $callback);
    }
    public function serve($server = '')
    {
        $this->setRequest($server);
        $this->response = new Response();
        $this->process();
    }
    private function setRequest($server)
    {
        if (empty($server)) {
            $server = $_SERVER;
        }
        $this->request = new Request($server);
    }
    public function get($path, $callback)
    {
        $this->routes[] = new Route($path, $callback, 'GET');
    }
    public function all($path, $callback)
    {
        $this->routes[] = new Route($path, $callback, 'ALL');
    }
    public function post($path, $callback)
    {
        $this->routes[] = new Route($path, $callback, 'POST');
    }
    public function delete($path, $callback)
    {
        $this->routes[] = new Route($path, $callback, 'DELETE');
    }
    public function patch($path, $callback)
    {
        $this->routes[] = new Route($path, $callback, 'PATCH');
    }
    public function put($path, $callback)
    {
        $this->routes[] = new Route($path, $callback, 'PUT');
    }
    private function process()
    {
        foreach ($this->routes as $route) {
            if ($route instanceof Route) {
                if ($route->match($this->request)) {
                    $reply = call_user_func($route->getCallback(), $this->request, $this->response);
                }
            } else {
                $this->called = false;
                $next = function () {
                    $this->called = true;
                };
                \call_user_func($route->getCallback(), $this->request, $this->response, $next);
                if (!$this->called) {
                    return;
                }
            }
        }
    }
}
