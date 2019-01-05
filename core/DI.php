<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 13:32
 */

namespace core;

/**
 * Class DI
 *
 * @package core
 *
 * @property Config $config
 * @property Routing $routing
 * @property Request $request
 * @property View $view
 * @property Auth $auth
 */
class DI
{
    #region [private properties]
    /** @var array $instances */
    private $instances;
    #endregion

    #region [private static properties]
    /** @var DI $instances */
    private static $instance;
    #endregion

    #region [public static methods]
    /**
     * @return DI
     */
    public static function init(): DI
    {
        return self::$instance ? self::$instance : (self::$instance = new self());
    }
    #endregion

    #region [public magic methods]
    /**
     * @param string $name
     * @param null $data
     *
     * @return DI
     */
    public function __set(string $name, $data = null): DI
    {
        if (isset($this->instances[$name])) {
            return $this;
        }

        if (is_object($data)) {
            $this->instances[$name] = $data;

            return $this;
        }

        if (is_string($data) && class_exists($data)) {
            $this->instances[$name] = new $data();

            return $this;
        }

        $this->instances[$name] = $data;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \ErrorException
     */
    public function __get(string $name)
    {
        if (!isset($this->instances[$name])) {
            throw new \ErrorException("{$name} not found");
        }

        return $this->instances[$name];
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->instances[$name]);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->instances);
    }

    /**
     * @param $name
     *
     * @return DI
     */
    public function __unset($name): DI
    {
        if (isset($this->instances[$name])) {
            unset($this->instances[$name]);
        }

        return $this;
    }

    /**
     * Config destruct
     */
    public function __destruct()
    {
        $this->instances = [];
        self::$instance  = null;
    }
    #endregion

    #region [private magic methods]
    /**
     * Prohibition of constructor
     *
     * DI constructor.
     */
    private function __construct()
    {
    }

    /**
     *  Prohibition of cloning
     */
    private function __clone()
    {
    }
    #endregion
}
