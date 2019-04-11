<?php
namespace Object\Types;

/**
 * Interface Singleton
 *
 * @package Object\Interface
 */
interface Singleton
{
	/**
	 * @return \Object\Traits\Singleton|static
	 */
	public static function getInstance();
}
