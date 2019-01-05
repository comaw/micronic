<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 17:38
 */

namespace app\controllers;

use app\models\Status;
use app\models\Task;
use core\App;
use core\ControllerBase;
use ErrorException;
use Throwable;

/**
 * Class HomeController
 *
 * @package app\controllers
 */
class HomeController extends ControllerBase
{
    /**
     *
     * @return string
     * @throws ErrorException
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public function indexAction()
    {
        $page = App::init()->request->getQuery('page', 1);
        $sort = App::init()->request->getQuery('sort', 'id');

        $model = new Task();
        $tasks = $model->getListOfTasks($page, $sort);
        $counts = $model->getCountTasks();

        return $this->render('index', [
            'tasks' => $tasks,
            'counts' => ceil($counts / Task::LIMIT_TO_PAGE),
            'page' => $page,
            'sort' => $sort,
        ]);
    }

    /**
     * @return string
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public function createAction()
    {
        if ($post = App::init()->request->getPost()) {
            $post['status_id'] = Status::STATUS_IN_PROGRESS;
            $model = new Task();
            try {
                $model->insert($post);
            } catch (Throwable $exception) {
                throw $exception;
            }

            $this->redirect('/');
        }

        return $this->render('create', []);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws ErrorException
     * @throws Throwable
     * @throws \Doctrine\DBAL\DBALException
     * @throws \ReflectionException
     */
    public function updateAction(int $id)
    {
        if (!App::init()->auth->getUserAuth()) {
            throw new \Exception('Access is denied');
        }
        $model = new Task();
        $task = $model->getById($id);
        if ($post = App::init()->request->getPost()) {
            if (!isset($post['status_id']) || $post['status_id'] != Status::STATUS_FINISHED) {
                $post['status_id'] = Status::STATUS_IN_PROGRESS;
            }
            try {
                $model->updateById($id, $post);
            } catch (Throwable $exception) {
                throw $exception;
            }

            $this->redirect('/');
        }

        return $this->render('update', [
            'task' => $task,
            'model' => $model,
        ]);
    }
}
