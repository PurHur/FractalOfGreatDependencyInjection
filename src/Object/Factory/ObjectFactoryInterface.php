<?php
namespace Object\Factory;

/**
 * Class ObjectManager
 */
interface ObjectFactoryInterface extends \Object\Types\Singleton
{
	/**
	 * @param $class
	 *
	 * @return object
	 */
	public function getObjectInstance($class);
}
