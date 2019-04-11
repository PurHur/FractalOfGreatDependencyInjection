<?php

namespace Object\Manager;

/**
 * Class ObjectManager
 *
 */
interface ObjectManagerInterface
{
	public static function get($className);

	/**
	 * @param $instance
	 */
	public static function injectDependencies($instance);
}