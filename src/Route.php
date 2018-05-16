<?php

namespace Resty;

class Route
{
    private $path;
    private $callback;
    private $method;

    public function __construct($path, $callback, $method)
    {
        $this->path = $path;
        $this->callback = $callback;
        $this->method = $method;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function getCallback()
    {
        return $this->callback;
    }
    public function getMethod()
    {
        return $this->method;
    }
    public function match($request)
    {
        $routeComponents = explode('/', $this->path);
        $uriComponents = explode('/', $request->getURI());
        $params = [];
        if (count($routeComponents) === count($uriComponents) && ($request->getMethod() === $this->getMethod() || $this->method === 'ALL')) {
            $arr = array_combine($routeComponents, $uriComponents);
            foreach ($arr as $key => $value) {
                $isVar = \strpos($key, ":") === 0;
                if ($isVar) {
                    $prop = \str_replace(':', '', $key);
                    $params[$prop] = $value;
                } else {
                    if ($key !== $value) {
                        return false;
                    }
                }
            }
            $request->setParams((object) $params);
            return true;
        } else {
            return false;
        }

    }
}
