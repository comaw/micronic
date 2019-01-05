<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 17:40
 */

namespace core;

use Doctrine\Common\Inflector\Inflector;

/**
 * Class ControllerBase
 *
 * @package core
 */
class ControllerBase
{
    #region [protected properties]
    /** @var string $layout */
    protected $layout = 'main';
    #endregion

    #region [public methods]
    /**
     * @param string $viewName
     * @param array $params
     *
     * @return string
     * @throws \ErrorException
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public function render(string $viewName, array $params = []): string
    {
        $content = $this->renderPartial($viewName, $params);

        return $this->renderPartial($this->layout, ['content' => $content], true);
    }

    /**
     * @param string $viewName
     * @param array $params
     * @param bool $layout
     *
     * @return string
     * @throws \ErrorException
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public function renderPartial(string $viewName, array $params = [], bool $layout = false): string
    {
        return App::init()->view->setController($this)->renderFile($viewName, $params, $layout);
    }

    /**
     * @param string $url
     */
    public function redirect(string $url)
    {
        header("Location: {$url}");

        exit();
    }

    /**
     * Refresh current page
     */
    public function refresh()
    {
        header("Refresh:0");

        exit();
    }
    #endregion
}
