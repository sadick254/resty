<?php

namespace Resty;

class Middleware
{
    private $path;
    private $callback;

    public function __construct($path, $callback)
    {
        $this->path = $path;
        $this->callback = $callback;
    }
    public function getCallback()
    {
        return $this->callback;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function match($request)
    {
        if ($this->path === 'ALL') {
            return true;
        }
        $routeComponents = explode('/', $this->path);
        $uriComponents = explode('/', $request->getURI());
        $params = [];
        if (count($routeComponents) === count($uriComponents)) {
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
