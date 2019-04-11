<?php
namespace Object\Proxy;

/**
 * Class LazyLoadingProxy
 *
 */
class LazyLoadingProxy implements \Object\Types\Singleton
{
    /**
     * @var string
     */
    protected $class = '';

    /**
     * @var $class
     */
    private $instance = null;

    /**
     * LazyLoadingSingletonProxy constructor.
     *
     * @param $class string Classname
     */
    public function __construct($class) {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public static function getInstance() {
        return self;
    }

    /**
     * @param $method
     * @param $args
     */
    public function __call($method, $args) {
        if ($method != 'initializeObject') {
            return $this->__getInstance()->$method(...$args);
        }
    }

    public static function __callStatic($method, $args) {
        return self::__call($method, $args);
    }

    private function getInstanceIfNeeded() {
        $factory = \Object\Manager\ObjectManager::getFactoryForClass($this->class);
        $newInstance = $factory->getObjectInstance($this->class);
        $this->instance = $newInstance;
    }

    public function __getInstance(){
        if ($this->instance === null) {
            $this->getInstanceIfNeeded();
        }

        return $this->instance;
    }
}
