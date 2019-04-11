<?php
namespace TestApplication\Controller;

class TestController
{
    use \Object\Traits\DependencyInjection;

    /**
     * @var int
     */
    protected $a = 1;

    /**
     * @var int
     */
    protected $b = 2;

    /**
     * @var SimpleSingletonService
     * @inject
     */
    protected $annotationInjectedSingleton;

    /**
     * @var SimpleSingletonService
     */
    protected $constructorInjectedSingleton;

    /**
     * ComplexTestService constructor.
     * @param SimpleSingletonService $contructorInjectedSingleton
     */
    public function __construct(SimpleSingletonService $contructorInjectedSingleton)
    {
        $this->constructorInjectedSingleton = $contructorInjectedSingleton;
    }

    /**
     * Now we testing the service with all possible calls
     */

    public function testAnnotationInjectionAction() {
        return $this->annotationInjectedSingleton->add($this->a,$this->b);
    }

    public function testConstructorInjectionAction() {
        return $this->constructorInjectedSingleton->add($this->a,$this->b);
    }

    public function testStaticObjectManagerCallAction() {
        $staticCallInjectedSingleton = \Object\Manager\ObjectManager::get(SimpleSingletonService::class);

        return $staticCallInjectedSingleton->add($this->a,$this->b);
    }

    // its beatiful
    public function testDirectStaticSingletonCallAction() {
        return SimpleSingletonService::add($this->a,$this->b);
    }

}
