<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 13:51
 */


return [
    'db'      => [
        'dbname'   => 'dbname',
        'user'     => 'root',
        'password' => '',
        'host'     => 'localhost',
        'driver'   => 'pdo_mysql',
    ],
    'routing' => [
        'controllerNamespace' => '\\app\\controllers\\',
        'defaultController'   => 'home',
        'defaultAction'       => 'index',
    ],
];
