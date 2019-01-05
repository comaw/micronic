<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 17:38
 */

namespace app\controllers;

use app\models\Admin;
use core\App;
use core\ControllerBase;
use ErrorException;
use Throwable;

/**
 * Class UserController
 *
 * @package app\controllers
 */
class UserController extends ControllerBase
{
    /**
     *
     * @return string
     * @throws ErrorException
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public function loginAction()
    {
        $model = new Admin();
        if ($post = App::init()->request->getPost()) {
            if ($model->validateLogin($post)) {
                $this->redirect('/');
            }
        }

        return $this->render('login', [
            'model' => $model,
            'post' => $post,
        ]);
    }

    /**
     * Logout of admin
     */
    public function logoutAction()
    {
        App::init()->auth->logout();

        $this->redirect('/');
    }
}
