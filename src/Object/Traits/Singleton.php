<?php
namespace Object\Traits;

/**
 * Trait Singleton
 *
 * @package Object\Traits
 */
trait Singleton
{
	use \Object\Traits\DependencyInjection;

	/**
	 * @var \Object\Traits\Singleton
	 */
	private static $instance = null;


	/**
	 * @return \Object\Traits\Singleton|static
	 */
	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new static();
			\Object\Manager\ObjectManager::injectDependencies(self::$instance);

			if (method_exists(self::$instance, 'initializeObject')) {
				self::$instance->initializeObject();
			}
		}

		return self::$instance;
	}
}
