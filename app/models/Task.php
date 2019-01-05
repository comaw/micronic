<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 20:33
 */

namespace app\models;

use core\ModelBase;

/**
 * Class Task
 *
 * @package app\models
 *
 * @property integer $id
 * @property integer $status_id
 * @property string $username
 * @property string $email
 * @property string $text
 * @property string $create_at
 * @property string $update_at
 */
class Task extends ModelBase
{
    public const LIMIT_TO_PAGE = 3;

    protected $tableName = 'task';
    protected $listOfFields = [
        'status_id', 'username', 'email', 'text'
    ];

    /**
     * @param int $page
     *
     * @param string $sort
     *
     * @return mixed[]
     */
    public function getListOfTasks(int $page = 1, string $sort = 'id')
    {
        if ($page < 1) {
            $page = 1;
        }
        $order = 'ASC';
        if (mb_substr($sort, 0, 1, 'UTF-8') == '-') {
            $sort = ltrim($sort, '-');
            $order = 'DESC';
        }

        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->select("*")
            ->from($this->tableName)
            ->orderBy($sort, $order)
            ->setFirstResult((($page - 1) * self::LIMIT_TO_PAGE))
            ->setMaxResults(self::LIMIT_TO_PAGE);

        $model = $queryBuilder->execute();

        return $model->fetchAll();
    }

    /**
     * @param int $id
     *
     * @return bool|mixed
     */
    public function getById(int $id)
    {
        if (!$id) {
            return null;
        }
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->select("*")
            ->from($this->tableName, 't')
            ->where('t.id = ?')
            ->setParameter(0, $id)
            ->setMaxResults(1);
        $queryBuilder = $queryBuilder->execute();

        return $queryBuilder->fetch();
    }

    /**
     * @return int
     */
    public function getCountTasks()
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->select("COUNT(*) as counts")
            ->from($this->tableName)
            ->setFirstResult(0)
            ->setMaxResults(3);

        $model = $queryBuilder->execute();
        $model = $model->fetch();

        return $model['counts'] ?? 0;
    }
}
