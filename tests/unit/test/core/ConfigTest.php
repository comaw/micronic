<?php

namespace test\core;

use core\Config;

/**
 * Class ConfigTest
 *
 * @package test\core
 */
class ConfigTest extends \Codeception\Test\Unit
{
    /** @var Config $config */
    protected $config;

    /**
     * @throws \ErrorException
     */
    protected function _before()
    {
        $this->config = new Config(__DIR__. '/../../../_data/config.php');
    }

    protected function _after()
    {
        unset($this->config);
    }

    // tests
    public function testConfigDb()
    {
        $this->assertArrayHasKey('dbname', $this->config->db);
        $this->assertArrayHasKey('user', $this->config->db);
        $this->assertArrayHasKey('password', $this->config->db);
        $this->assertArrayHasKey('host', $this->config->db);
        $this->assertArrayHasKey('driver', $this->config->db);
    }
}
