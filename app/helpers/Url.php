<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 23:25
 */

namespace app\helpers;

/**
 * Class Url
 *
 * @package app\helpers
 */
class Url
{

    /**
     * @param string $field
     * @param string $sort
     *
     * @return string
     */
    public static function createSort(string $field, string $sort = 'id'): string
    {
        return 'sort=' . ($sort == $field ? '-' : '') . $field;
    }

    /**
     * @param string $sort
     * @param int $page
     *
     * @return string
     */
    public static function createPrevious(string $sort, int $page = 1): string
    {
        return '?sort=' . $sort . ($page > 2 ? '&page=' . ($page - 1) : '' );
    }

    /**
     * @param string $sort
     * @param int $page
     *
     * @return string
     */
    public static function createNext(string $sort, int $page = 1): string
    {
        return '?sort=' . $sort . '&page=' . ($page + 1);
    }

    /**
     * @param string $sort
     * @param int $page
     *
     * @return string
     */
    public static function createList(string $sort, int $page = 1): string
    {
        return '?sort=' . $sort . ($page > 1 ? '&page=' . $page : '' );
    }
}
