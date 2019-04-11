<?php
namespace Object\Factory;

/**
 * Class SingletonObjectFactory
 *
 */
class SingletonObjectFactory implements ObjectFactoryInterface
{
	use \Object\Traits\Singleton;

	/**
	 * @param $class
	 *
	 * @return object
	 */
	public function getObjectInstance($class) {
		return new \Object\Proxy\LazyLoadingProxy($class);
	}
}
