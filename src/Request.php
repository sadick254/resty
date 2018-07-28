<?php

namespace Resty;

class Request
{
    private $server;
    private $headers;
    private $params;
    private $envs;

    public function __construct($server)
    {
        $this->server = $server;
        $this->envs = \array_merge(getenv(), $_SERVER, $_ENV);
    }
    public function getBody()
    {
        $post = $_POST;
        $input = json_decode(file_get_contents('php://input'), true) ?? array();
        return array_merge($post, $input);
    }
    public function getMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }
    public function getQueryParams()
    {
        \parse_str($this->server['QUERY_STRING'], $output);
        return (object) $output;
    }
    public function getHeaders()
    {
        return \getallheaders();
    }
    public function getHeader($header)
    {
        $headers = $this->getHeaders();
        if (!isset($headers[$header])) {
            return false;
        }
        return $headers[$header];
    }
    public function getURI()
    {
        return explode("?", $this->server['REQUEST_URI'])[0];
    }
    public function setParams($params)
    {
        $this->params = $params;
    }
    public function getParams()
    {
        return $this->params;
    }
    public function getProtocol()
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }
    public function isConnectionSecure()
    {
        if (!isset($_SERVER['HTTPS'])) {
            return false;
        }
        return $_SERVER['HTTPS'] === 'on';
    }
    public function getCookies()
    {
        return (object) $_COOKIE;
    }
    public function accepts($type)
    {
        return $this->is($type);
    }
    public function is($type)
    {
        return $_SERVER['CONTENT_TYPE'] === $type;
    }
    public function getIP()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
    public function getEnvs(): array
    {
        return $this->envs;
    }
    public function getEnv(string $env)
    {
        return $this->envs[$env];
    }
}
