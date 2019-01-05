<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 20:50
 */

namespace app\models;

use core\ModelBase;

/**
 * Class Status
 *
 * @package app\models
 */
class Status extends ModelBase
{
    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_FINISHED    = 2;

    protected $tableName    = 'status';
    protected $listOfFields = ['id', 'name', 'image'];
}
