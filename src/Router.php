<?php
namespace Resty;

class Router
{
    private $routes = [];
    private $request;
    private $middlewares = [];
    private $response;
    
    public  function allowCors()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET,POST,OPTIONS,PUT,DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Content-Type: application/json");
        header("Content-Type: *");
    }
    public function use()
    {
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
        $args = \func_get_args();
        $this->addRoute($args, 'GET');
    }
    public function all($path, $callback)
    {
        $args = \func_get_args();
        $this->addRoute($args, 'ALL');
    }
    public function post($path, $callback)
    {
        $args = \func_get_args();
        $this->addRoute($args, 'POST');
    }
    public function delete($path, $callback)
    {
        $args = \func_get_args();
        $this->addRoute($args, 'DELETE');
    }
    public function patch()
    {
        $args = \func_get_args();
        $this->addRoute($args, 'PATCH');
    }
    public function put()
    {
        $args = \func_get_args();
        $this->addRoute($args, 'PUT');
    }
    private function addRoute($args, $method)
    {
        foreach ($args as $key => $arg) {
            if (is_callable($arg)) {
                if ($this->isMiddleware($arg)) {
                    $this->routes[] = new Middleware($args[0], $args[$key]);
                } else {
                    $this->routes[] = new Route($args[0], $arg, $method);
                }
            }
        }
    }
    public function isMiddleware($func)
    {
        $closure = new \ReflectionFunction($func);
        return $closure->getNumberOfParameters() === 3;
    }
    private function process()
    {
        foreach ($this->routes as $route) {
            if ($route instanceof Route) {
                if ($route->match($this->request)) {
                    $reply = call_user_func($route->getCallback(), $this->request, $this->response);
                    
                    if ($reply) {
                        \is_array($reply) ?  $this->response->json($reply) : $this->response->send($reply);
                    }
                    return;
                }
            } else {
                if ($route->match($this->request)) {
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
}
