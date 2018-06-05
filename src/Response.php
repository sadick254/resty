<?php
namespace Resty;

class Response
{
    /**
     * Sends the set data to the requesting client
     *
     * @param [mixed] $data the data to be sent to the client
     *
     * @return void
     */
    public function send($data)
    {
        print_r($data);
    }
    /**
     * Sets the header of the response
     *
     * @param string $type  the type of header to be set
     * @param string $value the value of the header
     *
     * @return void
     */
    public function setHeader(string $type, string $value)
    {
        \header("$type: $value");
    }
    /**
     * Sends the file to the client for download
     *
     * @param string $path filepath of the path to be downloaded
     * @return void
     */
    public function download(string $path)
    {
        $chunks = \explode("/", $path);
        $length = \count($chunks);
        $filename = $chunks[$length - 1];
        $this->setHeader("Content-disposition", "attachment;filename=$filename");
        $this->sendFile($path);
    }
    /**
     * Sends a file to the requesting client
     *
     * @param string $path filepath of the file to be sent
     *
     * @return void
     */
    public function sendFile(string $path)
    {
        $finfo = \finfo_open(FILEINFO_MIME);
        $info = \finfo_file($finfo, $path);
        $this->setHeader("Content-Type", $info);
        $this->setHeader("Content-Length", filesize($path));
        \readfile($path);
        finfo_close($finfo);
    }
    /**
     * Appends additional header to the response
     *
     * @param string $type  the type of header to add
     * @param string $value the value of the header
     *
     * @return void
     */
    public function append(string $type, string $value)
    {
        $this->setHeader($type, $value);
    }
    /**
     * Sets the response Content-Disposition header to attachment
     *
     * @param string|null $path path to filename to be set
     *
     * @return void
     */
    public function attach(?string $path)
    {
    }
    /**
     * Sets cookie header with the name and value
     *
     * @param string $name    name of the cookie to be set
     * @param string $value   value to be set on the cookie
     * @param array  $options additional options to be set on the cookie
     *
     * @return void
     */
    public function setCookie(string $name, string $value, array $options)
    {
    }
    /**
     * Clears a cookie that was prevoiusly set
     *
     * @param string     $name    name of the cookie to be cleared
     * @param array|null $options options to use when clearing the cookie
     *
     * @return void
     */
    public function clearCookie(string $name, ?array $options)
    {
    }
    /**
     * Ends the response process
     *
     * @return void
     */
    public function end()
    {
    }
    /**
     * Gets the header specified by the type
     *
     * @param string $type type of header
     *
     * @return string
     */
    public function getHeader(string $type): string
    {
    }
    /**
     * Sends a json response
     *
     * @param array $data data to be sent to the client
     *
     * @return void
     */
    public function json(array $data)
    {
        $json = \json_encode($data);
        $this->setHeader("Content-Type", "application/json");
        $this->send($json);
    }
    /**
     * Sets the response HTTP status code to statusCode and send its string representation as the response body
     *
     * @param integer $code status code
     *
     * @return void
     */
    public function sendStatus(int $code)
    {
    }
    /**
     * Sets the HTTP status for the response
     *
     * @param integer $code status code
     *
     * @return void
     */
    public function setStatus(int $code)
    {
        \http_response_code($code);
    }
}
