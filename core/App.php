<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 04.01.2019
 * Time: 21:22
 */

namespace core;

/**
 * Class App
 *
 * @package core
 *
 * @property Config $config
 * @property Routing $routing
 * @property Request $request
 * @property View $view
 * @property Auth $auth
 */
class App
{
    #region [protected properties]
    /** @var DI $di */
    protected $di;
    #endregion

    #region [private properties]
    /** @var array $instance */
    private $instance;
    #endregion

    #region [private static properties]
    /** @var App $current */
    private static $current;
    #endregion

    #region [constructor]
    /**
     * App constructor.
     *
     * @param string $configFile
     *
     * @throws \ErrorException
     */
    public function __construct(string $configFile)
    {
        $this->di = DI::init();

        $this->di->config = new Config($configFile);
        $this->di->request = new Request();
        self::$current = $this;

        $this->di->routing = new Routing($this->request->getRout());
        $this->di->view    = new View();
        $this->di->auth    = new Auth();
    }
    #endregion

    #region [public static methods]
    /**
     * @return App
     */
    public static function init(): App
    {
        return self::$current;
    }
    #endregion

    #region [public methods]
    /**
     * @throws \ErrorException
     */
    public function run()
    {
        $controllerName = $this->routing->getController();
        if (!class_exists($controllerName)) {
            throw new \ErrorException("Controller {$controllerName} not found");
        }
        $controller = new $controllerName();
        $action = $this->routing->getAction();
        if (!method_exists($controller, $action)) {
            throw new \ErrorException("Action {$action} not found");
        }
        $params = $this->routing->getParams();

        echo call_user_func_array([$controller, $action], $params);
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
        if ($this->instance[$name]) {
            return $this->instance[$name];
        }

        if (!isset($this->di->{$name})) {
            throw new \ErrorException("DI {$name} not found");
        }

        return $this->di->{$name};
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return App
     */
    public function __set(string $name, $value): App
    {
        $this->instance[$name] = $value;

        return $this;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->di->{$name});
    }
    #endregion
}
