<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 20:53
 */

namespace app\models;

use core\App;
use core\ModelBase;

/**
 * Class Admin
 *
 * @package app\models
 *
 * @property string $error
 */
class Admin extends ModelBase
{
    public $error = null;

    protected $tableName = 'admin';
    protected $listOfFields = ['id', 'username', 'password', 'auth_key', 'create_at', 'update_at'];

    /**
     * @param array $params
     *
     * @return bool
     */
    public function validateLogin(array $params): bool
    {
        $this->error = null;
        if (!isset($params['username']) || !isset($params['password'])) {
            $this->error = 'Incorrect login or password';

            return false;
        }
        $queryBuilder = $this->db->createQueryBuilder();

        $queryBuilder->select("*")
            ->from($this->tableName, 'a')
            ->where('a.username = ?')
            ->setParameter(0, $params['username'] ?? '');
        $queryBuilder = $queryBuilder->execute();
        $model = $queryBuilder->fetch();
        if (!$model) {
            $this->error = 'Incorrect login or password';

            return false;
        }
        if (!password_verify($params['password'], $model['password'])) {
            $this->error = 'Incorrect login or password';

            return false;
        }
        $this->setLogin($model);

        return true;
    }

    /**
     * @param string $auth
     *
     * @return bool
     */
    public function getByAuth(string $auth)
    {
        if (!$auth) {
            return false;
        }
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->select("*")
            ->from($this->tableName, 'a')
            ->where('a.auth_key = ?')
            ->setParameter(0, $auth);
        $queryBuilder = $queryBuilder->execute();

        return $queryBuilder->fetch();
    }

    /**
     * @param $model
     *
     * @return Admin
     */
    protected function setLogin($model): Admin
    {
        $auth = md5(uniqid($model['id']).uniqid($model['id']).uniqid($model['create_at']));
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->update($this->tableName)
            ->set('auth_key', '?')
            ->setParameter(0, $auth)
            ->execute();

        App::init()->auth->setUserAuth($auth);

        return $this;
    }
}
