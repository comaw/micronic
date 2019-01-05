<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 20:15
 */

namespace core;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;

/**
 * Class ModelBase
 *
 * @package core
 */
class ModelBase
{
    #region [protected properties]
    /** @var string $tableName */
    protected $tableName = '';
    /** @var array $listOfFields */
    protected $listOfFields = [];
    /** @var array $values */
    protected $values = [];
    #endregion

    #region [protected properties]
    /** @var DriverManager $db */
    protected $db;
    #endregion

    #region [constructor]
    /**
     * ModelBase constructor.
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __construct()
    {
        $dbConfig = App::init()->config->db;
        $config = new Configuration();
        $connectionParams = array(
            'dbname'   => $dbConfig['dbname'],
            'user'     => $dbConfig['user'],
            'password' => $dbConfig['password'],
            'host'     => $dbConfig['host'],
            'driver'   => $dbConfig['driver'],
        );
        $this->db = DriverManager::getConnection($connectionParams, $config);
    }
    #endregion

    #region [constructor]
    /**
     * @param array $params
     *
     * @return $this
     */
    public function assert(array $params)
    {
        foreach ($params as $field => $value) {
            if (in_array($field, $this->listOfFields)) {
                $this->values[$field] = $value;
            }
        }

        return $this;
    }
    #endregion

    #region [public methods]
    /**
     * @param array $params
     *
     * @return \Doctrine\DBAL\Driver\Statement|int
     */
    public function insert(array $params = [])
    {
        if ($params) {
            $this->assert($params);
        }

        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->insert($this->tableName);
        $index = 0;
        foreach ($this->values as $field => $value) {
            $queryBuilder->setValue($field, '?')
                ->setParameter($index, $value);
            $index++;
        }

        return $queryBuilder->execute();
    }

    /**
     * @param int $id
     * @param array $params
     *
     * @return \Doctrine\DBAL\Driver\Statement|int
     */
    public function updateById(int $id, array $params = [])
    {
        if ($params) {
            $this->assert($params);
        }

        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->update($this->tableName);
        $index = 0;
        foreach ($this->values as $field => $value) {
            $queryBuilder->set($field, '?')
                ->setParameter($index, $value);
            $index++;
        }
        $queryBuilder->where("id = ?")
            ->setParameter($index, $id);

        return $queryBuilder->execute();
    }
    #endregion

    #region [public magic methods]
    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->values[$name] ?? null;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function __set(string $name, $value)
    {
        $this->values[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->values[$name]);
    }

    /**
     * @param string $name
     */
    public function __unset(string $name)
    {
        if (isset($this->values[$name])) {
            unset($this->values[$name]);
        }
    }
    #endregion
}
