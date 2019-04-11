<?php
namespace Object\Traits;

/**
 * Trait DependencyInjection
 *
 * @package Object\Traits
 */
trait DependencyInjection
{
	/**
     * hacky injection method....
     *
	 * @param string $propertyName
	 * @param mixed  $value
	 */
	public function __inject($propertyName, $value) {
		$this->$propertyName = $value;
	}
}
