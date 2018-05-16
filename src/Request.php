<?php

namespace Resty;

class Request
{
    private $server;
    private $headers;
    private $params;

    public function __construct($server)
    {
        $this->server = $server;
    }
    public function getBody()
    {
        return json_decode(file_get_contents('php://input'));
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
        return $this->getHeaders()[$header];
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
}
