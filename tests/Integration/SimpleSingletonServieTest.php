<?php

class SimpleSingletonServieTest extends \PHPUnit\Framework\TestCase
{

    public function testAdd() {
        $expected = 3;

        $simpleSingletonService = \Object\Manager\ObjectManager::get(\TestApplication\SimpleSingletonService::class);

        $value = $simpleSingletonService->add(1,2);

        $this->assertEquals($expected, $value);
    }
}