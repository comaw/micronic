<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 16:32
 */

namespace core;

use Doctrine\Common\Inflector\Inflector;

/**
 * Class Routing
 *
 * @package core
 */
class Routing
{
    #region [public constants]
    public const CONTROLLER_SUFFIX = 'Controller';
    public const ACTION_SUFFIX     = 'Action';
    #endregion

    #region [private properties]
    /** @var string $controllerNamespace */
    private $controllerNamespace = '\\app\\controllers\\';
    /** @var array $rout */
    private $rout = [];
    /** @var string $defaultController */
    private $defaultController = 'home';
    /** @var string $defaultAction */
    private $defaultAction = 'index';
    /** @var array $params */
    private $params = [];
    #endregion

    #region [constructor]
    /**
     * Routing constructor.
     *
     * @param string $rout
     */
    public function __construct(string $rout)
    {
        $this->rout = explode('/', $rout);
        array_walk($this->rout, [$this, 'trim']);

        $this->controllerNamespace = App::init()->config->routing['controllerNamespace'] ?? $this->controllerNamespace;
        $this->defaultController   = App::init()->config->routing['defaultController'] ?? $this->defaultController;
        $this->defaultAction       = App::init()->config->routing['defaultAction'] ?? $this->defaultAction;
    }
    #endregion

    #region [public methods]
    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controllerNamespace
            . Inflector::classify(isset($this->rout[0]) && $this->rout[0] ? $this->rout[0] : $this->defaultController)
            . self::CONTROLLER_SUFFIX;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return Inflector::camelize(isset($this->rout[1]) && $this->rout[1] ? $this->rout[1] : $this->defaultAction) . self::ACTION_SUFFIX;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        if (!$this->params) {
            $this->params = $this->rout;
            for ($i = 0; $i < 2; $i++) {
                if (isset($this->params[$i])) {
                    unset($this->params[$i]);
                }
            }
        }

        return $this->params;
    }
    #endregion

    #region [public methods]
    /**
     * @param string $string
     * @param null|string $charlist
     *
     * @return string
     */
    private function trim(string $string, string $charlist = "/"): string
    {
        return trim($string, $charlist);
    }
    #endregion
}
