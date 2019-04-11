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
    public $annotationInjectedSingleton;
    
    /**
     * @var SimpleSingletonService
     */
    public $constructorInjectedSingleton;

    /**
     * @var SimpleSingletonService
     */
    public $constructorInjectedSingleton;

    /**
     * ComplexTestService constructor.
     * @param SimpleSingletonService $contructorInjectedSingleton
     */
    public function __construct(SimpleSingletonService $contructorInjectedSingleton)
    {
        $this->constructorInjectedSingleton = $contructorInjectedSingleton;
    }
    
    public function injectInjectionMethodInjectedSingleton(SimpleSingletonService $injectionMethodInjectedSingleton) {
        $this->injectionMethodInjectedSingleton = $injectionMethodInjectedSingleton;
    }

    /**
     * Now we testing the service with all possible calls
     */

    public function testAnnotationInjectionAction() {
        return $this->annotationInjectedSingleton->add($this->a,$this->b);
    }
    
    public function testInjectionMethodInjectionAction() {
        return $this->injectionMethodInjectedSingleton->add($this->a,$this->b);
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
