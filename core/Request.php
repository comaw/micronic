<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 15:54
 */

namespace core;

/**
 * Class Request
 *
 * @package core
 */
class Request
{
    #region [protected properties]
    /** @var string $rout */
    protected $rout = '';
    /** @var string $serverName */
    protected $serverName = '';
    /** @var string $method */
    protected $method = 'GET';
    /** @var array $queries */
    protected $queries = [];
    /** @var string $contentType */
    protected $contentType;
    #endregion

    #region [constructor]
    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->setRout();

        $this->serverName  = $_SERVER['SERVER_NAME'] ?? '';
        $this->method      = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->queries     = $_GET;
        $this->contentType = $_SERVER["CONTENT_TYPE"] ?? 'text/html';
    }
    #endregion

    #region [public methods]
    /**
     * @return Request
     */
    public function setRout(): Request
    {
        $rout = $_SERVER['REQUEST_URI'] ?? '';
        $rout = explode('?', $rout);
        $rout = current($rout);
        $this->rout = trim($rout, '/');

        return $this;
    }

    /**
     * @param null|string $name
     *
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function getQuery(?string $name = null, $default = null)
    {
        if (!$name) {
            return $this->queries;
        }

        return $this->queries[$name] ?? $default;
    }

    /**
     * @param null|string $name
     *
     * @return mixed|null
     */
    public function getPost(?string $name = null)
    {
        if (!$name) {
            return $_POST;
        }

        return $_POST[$name] ?? null;
    }

    /**
     * @param null|string $name
     *
     * @param bool $decode
     *
     * @return mixed|null
     */
    public function getBody(?string $name = null, bool $decode = false)
    {
        $body = http_get_request_body();
        if (!$decode) {
            return $body;
        }

        if ($this->contentType == 'application/json' || $this->contentType == 'application/json;charset=utf-8') {
            $body = json_decode($body, true);
        } else {
            parse_str($body, $body);
        }
        if ($name) {
            return $body[$name] ?? null;
        }

        return $body;
    }

    /**
     * @return string
     */
    public function getRout(): string
    {
        return $this->rout;
    }

    /**
     * @return string
     */
    public function getReferer(): string
    {
        return $_SERVER['HTTP_REFERER'] ?? '';
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? '';
    }

    public function getUserIp(): string
    {
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    /**
     * @return bool
     */
    public function isHttps(): bool
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off');
    }
    #endregion
}
