<?php
namespace TestApplication\Service;

class SimpleSingletonService implements \Object\Types\Singleton
{
    use \Object\Traits\Singleton;

    /**
     * @param $a
     * @param $b
     * @return mixed
     */
    public function add($a, $b) {
        return $a + $b;
    }
}
