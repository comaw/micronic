<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 23:12
 */

namespace app\helpers;

use app\models\Status;

/**
 * Class StatusHelper
 *
 * @package app\helpers
 */
class StatusHelper
{
    /**
     * @param int $statusId
     *
     * @return string
     */
    public static function getImage(int $statusId): string
    {
        if ($statusId == Status::STATUS_FINISHED) {
            return '/images/ok.png';
        }

        return '/images/inprogress.png';
    }

    /**
     * @param int $statusId
     *
     * @return string
     */
    public static function getStatusName(int $statusId): string
    {
        if ($statusId == Status::STATUS_FINISHED) {
            return 'Finished';
        }

        return 'In progress';
    }
}
