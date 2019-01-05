<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 14:47
 */

namespace core;

/**
 * Class Config
 *
 * @package core
 *
 * @property array $db
 * @property array $routing
 */
class Config
{
    #region [private properties]
    /** @var string $file */
    private $file;
    /** @var array $settings */
    private $settings;
    #endregion

    #region [constructor]
    /**
     * Config constructor.
     *
     * @param string $file
     *
     * @throws \ErrorException
     */
    public function __construct(string $file)
    {
        $this->file = $file;

        $this->setConfig();
    }
    #endregion

    #region [public methods]
    /**
     * @return Config
     * @throws \ErrorException
     */
    public function setConfig(): Config
    {
        if (!$this->file) {
            throw new \ErrorException("Config file name not exist");
        }
        if (!file_exists($this->file)) {
            throw new \ErrorException("{$this->file} not found");
        }

        $this->settings = include($this->file);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function getConfig(string $name)
    {
        return $this->settings[$name] ?? null;
    }
    #endregion

    #region [public magic methods]
    /**
     * @param $name
     *
     * @return mixed|null
     * @throws \ErrorException
     */
    public function __get($name)
    {
        if (!isset($this->settings[$name])) {
            throw new \ErrorException("Config {$name} not found");
        }

        return $this->settings[$name];
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->settings[$name]);
    }
    #endregion
}
