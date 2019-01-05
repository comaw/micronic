<?php

namespace test\core;

use core\App;

/**
 * Class AppTest
 *
 * @package test\core
 */
class AppTest extends \Codeception\Test\Unit
{
    // tests
    /**
     * @throws \ErrorException
     */
    public function testAppConfig()
    {
        $app = new App(__DIR__. '/../../../_data/config.php');

        $this->assertArrayHasKey('dbname',$app->config->db);
        $this->assertArrayHasKey('user', $app->config->db);
        $this->assertArrayHasKey('password', $app->config->db);
        $this->assertArrayHasKey('host', $app->config->db);
        $this->assertArrayHasKey('driver', $app->config->db);
    }
}
