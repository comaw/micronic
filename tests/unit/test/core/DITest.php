<?php

namespace test\core;

use core\DI;

/**
 * Class DITest
 *
 * @package test\core
 */
class DITest extends \Codeception\Test\Unit
{
    /** @var DI $di */
    private $di;

    protected function _before()
    {
        $this->di = DI::init();
    }

    protected function _after()
    {
        unset($this->di);
    }

    // tests
    public function testSetArray()
    {
        $testData = [0 => 1, 'second' => 2];

        $this->di->testData = $testData;

        $this->assertArrayHasKey(0, $this->di->testData);
        $this->assertArrayHasKey('second', $this->di->testData);
        $this->assertEquals(1, $this->di->testData[0]);
        $this->assertEquals(2, $this->di->testData['second']);
    }

    public function testSetObject()
    {
        $testObject = new \stdClass();
        $testObject->first = 1;
        $testObject->second = 2;

        $this->di->testObject = $testObject;

        $this->assertEquals(1, $this->di->testObject->first);
        $this->assertEquals(2, $this->di->testObject->second);
    }

    public function testSetObjectByNamespace()
    {
        $this->di->testObjectNamespace = '\\test\_data\\TestObject';

        $this->assertEquals(1, $this->di->testObjectNamespace->first);
        $this->assertEquals(2, $this->di->testObjectNamespace->second);
    }
}
