<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 04.01.2019
 * Time: 17:53
 */

require __DIR__ . '/../vendor/autoload.php';

$configFile = __DIR__ . '/../app/config/main.php';

(new \core\App($configFile))->run();
