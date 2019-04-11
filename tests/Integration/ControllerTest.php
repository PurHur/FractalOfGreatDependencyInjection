<?php

use TestApplication\SimpleSingletonService;

class ControllerTest extends \PHPUnit\Framework\TestCase
{

    public function testDifferentInjectionMethodsSideBySide() {
        $testControllerInstance = \Object\Manager\ObjectManager::get(\TestApplication\Controller\TestController::class);


        $this->assertInstanceOf(
            \TestApplication\Service\SimpleSingletonService::class,
            $testControllerInstance->getConstructorInjectedSingleton()
        );

        $this->assertInstanceOf(
            \TestApplication\Service\SimpleSingletonService::class,
            $testControllerInstance->getAnnotationInjectedSingleton()
        );
        
        $this->assertInstanceOf(
            \TestApplication\Service\SimpleSingletonService::class,
            $testControllerInstance->getInjectionMethodInjectedSingleton()
        );

        $staticCallInjectedSingleton = \Object\Manager\ObjectManager::get(\TestApplication\Service\SimpleSingletonService::class);

        $this->assertInstanceOf(
            \TestApplication\Service\SimpleSingletonService::class,
            $staticCallInjectedSingleton
        );


        $this->assertSame(
            $testControllerInstance->getConstructorInjectedSingleton(),
            $testControllerInstance->getAnnotationInjectedSingleton()
        );

        $this->assertSame(
            $testControllerInstance->getConstructorInjectedSingleton(),
            $staticCallInjectedSingleton
        );
        
        $this->assertSame(
            $testControllerInstance->getInjectionMethodInjectedSingleton(),
            $staticCallInjectedSingleton
        );
    }
}
