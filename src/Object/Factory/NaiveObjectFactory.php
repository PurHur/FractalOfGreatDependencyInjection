<?php
namespace Object\Factory;

/**
 * Class ObjectManager
 */
class NaiveObjectFactory implements ObjectFactoryInterface
{
	use \Object\Traits\Singleton;

	/**
	 * @param $class
	 *
	 * @return object
	 */
	public function getObjectInstance($class) {
		return new $class;
	}
}
