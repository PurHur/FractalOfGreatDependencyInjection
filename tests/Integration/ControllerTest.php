<?php

use TestApplication\SimpleSingletonService;

class ControllerTest extends \PHPUnit\Framework\TestCase
{

    public function testDifferentInjectionMethodsSideBySide() {
        $testControllerInstance = \Object\Manager\ObjectManager::get(\TestApplication\Controller\TestController::class);


        $this->assertInstanceOf(
            \TestApplication\Service\SimpleSingletonService::class,
            $testControllerInstance->$constructorInjectedSingleton
        );

        $this->assertInstanceOf(
            \TestApplication\Service\SimpleSingletonService::class,
            $testControllerInstance->$annotationInjectedSingleton
        );
        
        $this->assertInstanceOf(
            \TestApplication\Service\SimpleSingletonService::class,
            $testControllerInstance->$injectionMethodInjectedSingleton
        );

        $staticCallInjectedSingleton = \Object\Manager\ObjectManager::get(
            \TestApplication\Service\SimpleSingletonService::class
        );

        $this->assertInstanceOf(
            \TestApplication\Service\SimpleSingletonService::class,
            $staticCallInjectedSingleton
        );


        $this->assertSame(
            $testControllerInstance->$constructorInjectedSingleton,
            $testControllerInstance->$annotationInjectedSingleton
        );

        $this->assertSame(
            $testControllerInstance->$constructorInjectedSingleton,
            $staticCallInjectedSingleton
        );
        
        $this->assertSame(
            $testControllerInstance->$injectionMethodInjectedSingleton,
            $staticCallInjectedSingleton
        );
    }
}
