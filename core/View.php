<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 18:23
 */

namespace core;

use Doctrine\Common\Inflector\Inflector;

/**
 * Class View
 *
 * @package core
 */
class View
{
    #region [public constants]
    public const FILE_EXT    = '.php';
    public const LAYOUT_PATH = '/../app/views/layout/';
    #endregion

    #region [protected properties]
    /** @var ControllerBase $controller */
    protected $controller;
    #endregion

    #region [public methods]
    /**
     * @param ControllerBase $controller
     *
     * @return View
     */
    public function setController(ControllerBase $controller): View
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * @param string $file
     * @param array $params
     *
     * @param bool $layout
     *
     * @return false|string
     * @throws \ErrorException
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public function renderFile(string $file, array $params = [], bool $layout = false)
    {
        $viewPath = $layout ? __DIR__ . self::LAYOUT_PATH : $this->getViewPath();
        $file     = $viewPath . $file . self::FILE_EXT;

        $obInitialLevel = ob_get_level();
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        try {
            require $file;

            return ob_get_clean();
        } catch (\Exception $e) {
            while (ob_get_level() > $obInitialLevel) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $obInitialLevel) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }
    #endregion

    #region [protected methods]
    /**
     * @return string
     * @throws \ErrorException
     * @throws \ReflectionException
     */
    protected function getViewPath()
    {
        $reflection = new \ReflectionClass($this->controller);
        $viewDirName = str_replace(['_controller', '_'], ['', '-'], Inflector::tableize($reflection->getShortName()));
        $path = __DIR__ . '/../app/views/' . $viewDirName . '/';
        if (!is_dir($path)) {
            throw new \ErrorException("{$path} not found");
        }

        return $path;
    }
    #endregion
}
